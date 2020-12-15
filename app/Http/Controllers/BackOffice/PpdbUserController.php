<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\PpdbUserDataTable;
use App\Enums\PaymentFraudStatus;
use App\Enums\Role;
use App\Garages\ImageOptimizer\OptimizerChainFactory;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentCreateRequest;
use App\Models\Payment;
use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\Transaction;
use App\Services\PpdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbUserController extends Controller
{
    use HasSiteContext;

    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    public function index(Request $request, $subDomain, Ppdb $ppdb)
    {
        $this->authorize('viewAny', PpdbUser::class);

        $datatable = new PpdbUserDataTable($ppdb);

        return $datatable->render('backoffice.ppdb.users.index');
    }

    public function show($subDomain, Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->authorize('view', $ppdbUser);

        $transactionItem = $ppdbUser->transactionItem()->firstOrFail();

        return view('backoffice.ppdb.users.show', compact('ppdbUser', 'transactionItem'));
    }

    public function directShow(Request $request, $subDomain)
    {
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        $ppdbUser = $this->ppdbService->latestPpdbUserFor($authUser);

        if (is_null($ppdbUser)) {
            abort(404);
        }

        $transactionItem = $ppdbUser->transactionItem;

        return view('backoffice.ppdb.users.show', compact('ppdbUser', 'transactionItem'));
    }

    public function showPayment($subDomain, Ppdb $ppdb, PpdbUser $ppdbUser, Transaction $transaction)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->userShouldOwnTransaction($ppdbUser, $transaction);
        $this->authorize('viewPayment', $ppdbUser);

        // @TODO: Validate if the transaction is already invalid

        if (! is_null($transaction->payment)) {
            abort(403);
        }

        return view('backoffice.ppdb.users.payment', compact('ppdbUser', 'transaction'));
    }

    public function storePayment(
        PaymentCreateRequest $request,
        $subDomain,
        Ppdb $ppdb,
        PpdbUser $ppdbUser,
        Transaction $transaction
    ) {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->userShouldOwnTransaction($ppdbUser, $transaction);
        $this->authorize('createPayment', [$ppdbUser, $transaction]);

        $requestData = $request->validated();

        DB::transaction(function () use ($requestData, $transaction) {
            $optimizerChain = OptimizerChainFactory::create(['quality' => 40]);
            $optimizerChain->optimize($requestData['proof_file']->path());

            /** @var \App\Models\Payment $payment */
            $payment = $transaction->payment()->save(new Payment([
                'provider_holder_name' => $requestData['provider_holder_name'],
                'provider_number' => $requestData['provider_number'],
                'paid_on' => $requestData['payment_datetime'],
            ]));

            $payment->addMedia($requestData['proof_file'])
                ->toMediaCollection('proof');
        });

        flash(
            'Bukti Pembayaran berhasil diunggah. Pendaftaran Anda akan
            diverifikasi oleh Admin.'
        )->success();

        return redirect()->to(sub_route('backoffice.ppdb.users.show', [$ppdb, $ppdbUser]));
    }

    public function acceptPayment($subDomain, Ppdb $ppdb, PpdbUser $ppdbUser, Transaction $transaction)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->userShouldOwnTransaction($ppdbUser, $transaction);
        $this->authorize('acceptPayment', $ppdbUser);

        if ($transaction->payment->isVerified()) {
            flash(
                'Pembayaran telah terverifikasi sebelumnya.'
            )->error();
        } else {
            $transaction->payment->forceFill([
                'verified_at' => now(),
            ])->save();

            flash(
                'Berhasil memverifikasi pembayaran.'
            )->success();
        }

        return redirect()->back();
    }

    public function declineOrCancelPayment(
        $subDomain,
        Ppdb $ppdb,
        PpdbUser $ppdbUser,
        Transaction $transaction
    ) {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->userShouldOwnTransaction($ppdbUser, $transaction);
        $this->authorize('declineOrCancelPayment', $ppdbUser);

        if (! $transaction->isPending()) {
            $fraudStatus = null;

            flash(
                'Berhasil membatalkan pembayaran.'
            )->success();
        } else {
            $fraudStatus = PaymentFraudStatus::FRAUD;

            flash(
                'Berhasil menolak pembayaran.'
            )->success();
        }

        $transaction->payment->forceFill([
            'verified_at' => null,
            'fraud_status' => $fraudStatus,
        ])->save();

        return redirect()->back();
    }

    public function acceptAsStudent($subDomain, Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->authorize('acceptAsStudent', $ppdbUser);

        /** @var \App\Models\Site $site */
        $site = $ppdbUser->ppdb->academicYear->site;
        /** @var \App\Models\Student $student */
        $student = $ppdbUser->user->studentProfileFor($site);

        if ($student->isAccepted()) {
            flash(
                'Peserta telah diterima sebagai ' .
                Role::getDescription(Role::STUDENT) .
                ' sebelumnya.'
            )->error();
        } else {
            $student->forceFill([
                'accepted_at' => now(),
                'declined_at' => null,
            ])->save();

            flash(
                'Berhasil menerima peserta menjadi ' .
                Role::getDescription(Role::STUDENT) . '.'
            )->success();
        }

        return redirect()->back();
    }

    public function declineOrCancelAsStudent($subDomain, Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);
        $this->authorize('declineOrCancelAsStudent', $ppdbUser);

        /** @var \App\Models\Site $site */
        $site = $ppdbUser->ppdb->academicYear->site;
        /** @var \App\Models\Student $student */
        $student = $ppdbUser->user->studentProfileFor($site);

        if (! $student->isPending()) {
            $student->forceFill([
                'accepted_at' => null,
                'declined_at' => null,
            ])->save();

            flash(
                'Berhasil membatalkan peserta menjadi ' .
                Role::getDescription(Role::STUDENT) . '.'
            )->success();
        } else {
            $student->forceFill([
                'accepted_at' => null,
                'declined_at' => now(),
            ])->save();

            flash(
                'Berhasil menolak peserta menjadi ' .
                Role::getDescription(Role::STUDENT) . '.'
            )->success();
        }

        return redirect()->back();
    }

    protected function userShouldOwnTransaction(PpdbUser $ppdbUser, Transaction $transaction)
    {
        $isOwner = $transaction->transactionItems()
            ->hasMorph('itemable', PpdbUser::class)
            ->where('itemable_id', $ppdbUser->id)
            ->exists();

        if (! $isOwner) {
            abort(404);
        }
    }

    protected function userShouldBelongsToPpdb(Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        if (! $ppdb->is($ppdbUser->ppdb)) {
            abort(404);
        }
    }
}

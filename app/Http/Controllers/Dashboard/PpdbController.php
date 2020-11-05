<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\PpdbUserDataTable;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PpdbUser;
use App\Models\Transaction;
use App\Services\PpdbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbController extends Controller
{
    use HasSiteContext;

    /**
     * @var \App\Services\PpdbService
     */
    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        if ($authUser->isNotAdmin() && $authUser->isNotSuperAdmin()) {
            abort(403);
        }

        $ppdb = $this->ppdbService->currentPpdb();

        $datatable = new PpdbUserDataTable($ppdb);

        return $datatable->render('dashboard.ppdb.index');
    }

    public function showUser($subDomain, PpdbUser $ppdbUser)
    {
        $this->checkPermission($ppdbUser);

        $transactionItem = $ppdbUser->transactionItem()->firstOrFail();

        return view('dashboard.ppdb.show_user', compact('ppdbUser', 'transactionItem'));
    }

    public function directShowUser(Request $request, $subDomain)
    {
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();
        $ppdb = $this->ppdbService->currentPpdb();

        if (is_null($ppdb)) {
            abort(404);
        }

        /** @var \App\Models\PpdbUser $ppdbUser */
        $ppdbUser = $ppdb->ppdbUsers()
            ->where('user_id', $authUser->id)
            ->firstOrFail();

        $transactionItem = $ppdbUser->transactionItem()->firstOrFail();

        return view('dashboard.ppdb.show_user', compact('ppdbUser', 'transactionItem'));
    }

    public function showPayment($subDomain, PpdbUser $ppdbUser, Transaction $transaction)
    {
        if (! $this->ownTransaction($ppdbUser, $transaction)) {
            abort(404);
        }
        $this->checkPermission($ppdbUser);

        // @TODO: Validate if the transaction is already invalid

        if (! is_null($transaction->payment)) {
            abort(403);
        }

        return view('dashboard.ppdb.payment', compact('ppdbUser', 'transaction'));
    }

    public function storePayment(Request $request, $subDomain, PpdbUser $ppdbUser, Transaction $transaction)
    {
        if (! $this->ownTransaction($ppdbUser, $transaction)) {
            abort(404);
        }
        $this->checkPermission($ppdbUser);

        if (! is_null($transaction->payment)) {
            abort(403);
        }

        $this->validate($request, [
            'provider_holder_name' => 'required|max:50',
            'provider_number' => 'required|digits_between:5,30',
            'payment_date' => 'required|date_format:d-m-Y',
            'payment_time' => 'date_format:"H:i"',
            'proof_file' => 'required|file|mimes:png,jpg,jpeg|max:1000',
        ], [], [
            'provider_holder_name' => 'Nama Pengirim',
            'provider_number' => 'Nomor Rekening',
            'payment_date' => 'Tanggal Pembayaran',
            'payment_time' => 'Waktu Pembayaran',
            'proof_file' => 'Bukti Pembayaran',
        ]);

        DB::transaction(function () use ($request, $transaction) {
            /** @var \App\Models\Payment $payment */
            $payment = $transaction->payment()->save(new Payment([
                'provider_holder_name' => $request->provider_holder_name,
                'provider_number' => $request->provider_number,
                'paid_on' => Carbon::createFromFormat(
                    'd-m-Y H:i',
                    $request->payment_date . ' ' . $request->get('payment_time', '00:00')
                ),
            ]));

            $payment->addMedia($request->proof_file)
                ->toMediaCollection('proof');
        });

        flash(
            'Bukti Pembayaran berhasil diunggah. Pendaftaran Anda akan
            diverifikasi oleh Admin.'
        )->success();

        return redirect()->to(sub_route('dashboard.ppdb.users.show', $ppdbUser));
    }

    protected function checkPermission(PpdbUser $ppdbUser)
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        if ($authUser->isNotSuperAdmin() &&
            $authUser->isNotAdmin() &&
            $authUser->isNot($ppdbUser->user)
        ) {
            abort(403);
        }
    }

    protected function ownTransaction(PpdbUser $ppdbUser, Transaction $transaction)
    {
        return $transaction->transactionItems()
            ->hasMorph('itemable', PpdbUser::class)
            ->where('itemable_id', $ppdbUser->id)
            ->exists();
    }
}

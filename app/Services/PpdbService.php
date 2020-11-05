<?php

namespace App\Services;

use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\Site;
use App\Models\User;

class PpdbService extends BaseService
{
    /**
     * @var \App\Services\TransactionService
     */
    protected $transactionService;

    /**
     * @var \App\Services\TransactionItemService
     */
    protected $transactionItemService;

    public function __construct(
        TransactionService $transactionService,
        TransactionItemService $transactionItemService
    ) {
        $this->transactionService = $transactionService;
        $this->transactionItemService = $transactionItemService;
    }

    public function addNewRegistrar(Ppdb $ppdb, User $user, array $data)
    {
        $ppdbUser = $ppdb->ppdbUsers()->save(new PpdbUser([
            'user_id' => $user->id,
            'selection_method' => $data['selection_method'],
        ]));

        $paymentDetails = $ppdbUser->ppdb->paymentDetails();

        $transaction = $this->transactionService->create([
            'payment_type' => $paymentDetails['payment_type'],
            'provider' => $paymentDetails['provider'],
            'provider_number' => $paymentDetails['provider_number'],
            'provider_holder_name' => $paymentDetails['provider_holder_name'],
            'valid_until' => now()->addMonths(6),
        ]);

        $this->transactionItemService->create($transaction, $ppdbUser, [
            'name' => 'Biaya Pendaftaran PPDB ' . $ppdbUser->ppdb->academicYear->name,
            'price' => $ppdbUser->ppdb->price(),
        ]);
    }

    public function currentPpdb(): ?Ppdb
    {
        $ppdb = null;
        /** @var \App\Models\AcademicYear|null $academicYear */
        $academicYear = $this->site()->academicYears()
            ->orderBy('from', 'desc')
            ->first();

        if ($academicYear) {
            $ppdb = $academicYear->ppdb()
                ->latest()
                ->first();
        }

        return $ppdb;
    }

    protected static function site(): ?Site
    {
        $site = app()->make('site');

        return empty($site) ? null : $site;
    }
}

<?php

namespace App\Services;

use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\User;

class PpdbService extends BaseService
{
    /**
     * @var \App\Services\TransactionService
     */
    protected $transactionService;

    /**
     * @var \App\Models\Ppdb|bool|null
     */
    private $currentPpdb_;

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
        if (! is_null($ppdb = $this->currentPpdb_)) {
            return $ppdb ? $ppdb : null;
        }

        $ppdb = null;
        /** @var \App\Models\AcademicYear|null $academicYear */
        $academicYear = site()->academicYears()
            ->orderBy('from', 'desc')
            ->first();

        if ($academicYear) {
            /** @var \App\Models\Ppdb|null $ppdb */
            $ppdb = $academicYear->ppdb()
                ->latest()
                ->first();
        }

        $this->currentPpdb_ = is_null($ppdb) ? false : $ppdb;

        return $ppdb;
    }

    public function latestPpdbUserFor(User $user): ?PpdbUser
    {
        /** @var \App\Models\PpdbUser|null $ppdbUser */
        $ppdbUser = $user->ppdbUsers()
            ->latest()
            ->first();

        return $ppdbUser;
    }
}

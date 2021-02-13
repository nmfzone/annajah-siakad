<?php

namespace Tests\Concerns;

use App\Enums\PaymentProvider;
use App\Enums\PaymentType;
use App\Models\AcademicYear;
use App\Models\Ppdb;
use App\Models\Site;
use App\Services\PpdbService;

trait CreatesPpdb
{
    protected $ppdbService;

    public function createPpdbFor(Site $site): Ppdb
    {
        AcademicYear::factory()->create([
            'site_id' => $site->id,
        ]);

        $ppdb = Ppdb::factory()->create();

        $ppdb->settings()->setMultiple([
            'price' => 100000,
            'payment' => [
                'provider' => PaymentProvider::BNI,
                'payment_type' => PaymentType::BANK_TRANSFER,
                'provider_number' => '012663937646',
                'provider_holder_name' => 'Medina, S.Pd',
            ],
            'contact_persons' => [
                [
                    'name' => 'Mufid, S.Pd',
                    'number' => '081392761430',
                ]
            ],
        ]);

        return $ppdb;
    }

    public function makePpdbService(): PpdbService
    {
        if ($this->ppdbService) {
            return $this->ppdbService;
        }

        return $this->app->make(PpdbService::class);
    }
}

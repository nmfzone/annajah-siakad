<?php

namespace Tests\Browser;

use App\Enums\PaymentProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\DatePicker;
use Tests\Browser\Pages\PpdbRegistrationPage;
use Tests\Concerns\CreatesPpdb;
use Tests\Concerns\CreatesSite;
use Tests\DuskTestCase;

class PpdbRegistrationTest extends DuskTestCase
{
    use CreatesPpdb,
        CreatesSite,
        DatabaseMigrations;

    protected $site;

    protected $ppdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = $this->createSubSite();
        $this->ppdb = $this->createPpdbFor($this->site);
    }

    /** @test */
    public function a_visitor_can_register_to_the_ppdb()
    {
        $this->browse(function (Browser $browser) {
            $paymentDetails = $this->ppdb->paymentDetails();

            $browser->visit(new PpdbRegistrationPage($this->site))
                ->customAssertSee(
                    'Penjaringan Peserta Didik Baru Tahun Pelajaran ' .
                    $this->ppdb->academicYear->name
                )
                ->press('Daftar Sekarang')
                ->pause(2000)
                ->type('name', 'Jane Doe')
                ->type('nickname', 'Jane')
                ->type('no_kk', '3401011002930003')
                ->type('birth_place', 'Yogyakarta')
                ->click('#birth_date')
                ->pause(200)
                ->within(new DatePicker('#birth_date'), function (Browser $browser) {
                    $browser->selectDate(1993, 2, 10);
                })
                ->radio('gender', 0)
                ->type('previous_school', 'SD Negeri 1 Yogyakarta')
                ->type('wali_name', 'John Doe, ST')
                ->type('wali_phone', '081328913824')
                ->select('selection_method', 'tahfidz')
                ->check('approval')
                ->press('Daftar')
                ->scrollFromTop(1000)
                ->assertSee(
                    'Selamat, Anda telah masuk ke daftar inden santri ' .
                    $this->site->title
                )
                ->assertSee(PaymentProvider::getDescription($paymentDetails['provider']))
                ->assertSee($paymentDetails['provider_holder_name']);
        });
    }
}

<?php

namespace Tests\Browser;

use App\Models\AcademicYear;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\DatePicker;
use Tests\Browser\Components\VueFormSelect;
use Tests\Browser\Pages\CreatePpdbPage;
use Tests\Concerns\CreatesSite;
use Tests\Concerns\CreatesUser;
use Tests\DuskTestCase;

class PpdbTest extends DuskTestCase
{
    use CreatesSite,
        CreatesUser,
        DatabaseMigrations;

    protected $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = $this->createSubSite();
    }

    /** @test */
    public function it_can_create_a_ppdb()
    {
        $user = $this->createAdminFor($this->site);
        factory(AcademicYear::class)->create([
            'from' => 2021,
            'to' => 2022,
            'site_id' => $this->site->id,
        ]);
        factory(AcademicYear::class)->create([
            'from' => 2020,
            'to' => 2021,
            'site_id' => $this->site->id,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $academicYearComponent = new VueFormSelect('#academic_year_id');

            $browser->loginAs($user)
                ->visit(new CreatePpdbPage($this->site))
                ->assertSee('Tambah PPDB')
                ->click('#academic_year_id')
                ->waitFor($academicYearComponent->elements()['@values'])
                ->within($academicYearComponent, function (Browser $browser) {
                    $browser->selectValue('2020/2021');
                })
                ->click('#start_date')
                ->pause(200)
                ->within(new DatePicker('#start_date'), function (Browser $browser) {
                    $browser->selectDate(1921, 2, 20);
                })
                ->type('#start_time', '20:30')
                ->click('#end_date')
                ->pause(200)
                ->within(new DatePicker('#end_date'), function (Browser $browser) {
                    $browser->selectDate(2020, 2, 20);
                })
                ->type('#end_time', '11:30')
                ->type('#price', 100000)
                ->select('#payment_provider', 'mandiri')
                ->select('#payment_type', 'bank_transfer')
                ->type('#payment_provider_number', '0512839301828')
                ->type('#payment_provider_holder_name', 'John Doe')
                ->type('#contact_persons_name_0', 'Jane Doe')
                ->type('#contact_persons_number_0', '081328019287')
                ->press('Simpan')
                ->assertHostIs($this->site->domain)
                ->assertPathIs('/backoffice/ppdb')
                ->assertSee('Berhasil menambahkan PPDB.');
        });
    }
}

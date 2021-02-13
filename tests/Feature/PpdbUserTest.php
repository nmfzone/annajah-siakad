<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\Concerns\CreatesPpdbUser;
use Tests\Concerns\CreatesSite;
use Tests\Concerns\CreatesUser;
use Tests\TestCase;

class PpdbUserTest extends TestCase
{
    use WithFaker,
        CreatesSite,
        CreatesUser,
        CreatesPpdbUser,
        RefreshDatabase;

    protected $site;

    protected $ppdb;

    protected $user;

    protected $ppdbUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = $this->createSubSite();
        $this->ppdb = $this->createPpdbFor($this->site);
        $this->user = $this->createStudentFor($this->site);
        $this->ppdbUser = $this->createPpdbUser($this->ppdb, $this->user);

        // Make sure we're on sub site, so we can use sub_route() helper.
        $this->get($this->getFullSubUrl($this->site));
    }

    /** @test */
    public function applicant_can_see_its_ppdb_registration_detail()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $this
            ->get(sub_route('backoffice.ppdb.users.direct_show'))
            ->assertStatus(200)
            ->assertSeeText($this->user->username)
            ->assertSeeText($this->user->name)
            ->assertSeeText($this->user->email)
            ->assertSeeText('Menunggu Pembayaran')
            ->assertSeeText('Detail Pendaftaran PPDB');
    }

    /** @test */
    public function applicant_can_upload_payment_proof()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user);

        $this
            ->followingRedirects()
            ->post(sub_route('backoffice.ppdb.users.store_payment', [
                'ppdb' => $this->ppdb,
                'ppdb_user' => $this->ppdbUser,
                'transaction' => $this->ppdbUser->transactionItem->transaction,
            ]), [
                'provider_holder_name' => 'John Doe',
                'provider_number' => '74192839810',
                'payment_date' => now()->format('d-m-Y'),
                'payment_time' => '21:30',
                'proof_file' => UploadedFile::fake()->image('proof_file.jpg'),
            ])
            ->assertSessionDoesntHaveErrors()
            ->assertSeeText('Proses Verifikasi');
    }

    /** @test */
    public function it_fails_to_upload_payment_proof_if_file_size_exceed_the_limit()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user);

        $this
            ->post(sub_route('backoffice.ppdb.users.store_payment', [
                'ppdb' => $this->ppdb,
                'ppdb_user' => $this->ppdbUser,
                'transaction' => $this->ppdbUser->transactionItem->transaction,
            ]), [
                'provider_holder_name' => 'John Doe',
                'provider_number' => '74192839810',
                'payment_date' => now()->format('d-m-Y'),
                'payment_time' => '21:30',
                'proof_file' => UploadedFile::fake()
                    ->image('proof_file.jpg')
                    ->size(6000),
            ])
            ->assertSessionHasErrors([
                'proof_file',
            ]);
    }
}

<div class="row">
  <div class="col-10 mx-auto">
    <div class="card {{ $transactionItem->isPaid() ? 'card-info' : 'card-danger' }}">
      <div class="card-header">
        <h3 class="card-title">Tagihan</h3>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-12 px-10 py-6 bg-gray-200 flex flex-wrap items-start">
            <div class="w-full md:w-2/3">
              <p>{{ $transactionItem->name }}</p>
              <p>{{ $transactionItem->priceFormatted() }}</p>
            </div>
            <div class="w-full md:w-1/3 flex flex-col">
              @if(is_null($transactionItem->transaction->payment))
                <div class="text-red-700 font-bold rounded-lg text-center">
                  Menunggu Pembayaran
                </div>

                <a href="{{ sub_route('backoffice.ppdb.users.show_payment', [
                    'ppdb' => $ppdbUser->ppdb,
                    'ppdb_user' => $ppdbUser,
                    'transaction' => $transactionItem->transaction
                  ]) }}" class="mt-4 py-2 px-6 bg-blue-600 hover:bg-blue-800 text-white rounded-lg text-center">
                  Unggah Bukti
                </a>
              @else
                @if($transactionItem->isPending())
                  <div class="{{ auth()->user()->isSuperAdminOrAdmin()
                                  ? 'text-yellow-600' : 'py-2 px-6 bg-yellow-600 text-white' }}
                    font-bold rounded-lg text-center">
                    Proses Verifikasi
                  </div>

                  @if(Gate::allows('acceptPayment', $ppdbUser))
                    <a class="mt-2 w-full border-none py-2 px-6 bg-blue-600 hover:bg-blue-800
                              text-white rounded-lg text-center submit-this"
                       data-message="Apakah Anda yakin akan menerima pembayaran dari peserta ini?"
                       href="{{ sub_route('backoffice.ppdb.users.accept_payment', [
                        'ppdb' => $ppdbUser->ppdb,
                        'ppdb_user' => $ppdbUser,
                        'transaction' => $transactionItem->transaction
                      ]) }}">
                      Terima Pembayaran
                    </a>
                  @endif
                @else
                  @if($transactionItem->isDeclined())
                    <div class="{{ auth()->user()->isSuperAdminOrAdmin()
                                    ? 'text-red-600' : 'py-2 px-6 bg-red-600 text-white' }}
                      font-bold rounded-lg text-center">
                      Pembayaran Ditolak
                    </div>
                  @else
                    <div class="{{ auth()->user()->isSuperAdminOrAdmin()
                                      ? 'text-green-600' : 'py-2 px-6 bg-green-600 text-white' }}
                      font-bold rounded-lg text-center">
                      Terverifikasi
                    </div>
                  @endif
                @endif

                @can('declineOrCancelPayment', $ppdbUser)
                  <a class="mt-2 w-full border-none py-2 px-6 bg-red-600 hover:bg-red-800
                          text-white rounded-lg text-center submit-this"
                     data-message="{{ ! $transactionItem->isPending()
                          ? 'Apakah Anda yakin akan membatalkan '. ($transactionItem->isPaid() ? 'penerimaan' : 'penolakan') . ' pembayaran dari peserta ini?'
                          : 'Apakah Anda yakin akan menolak pembayaran dari peserta ini?' }}"
                     href="{{ sub_route('backoffice.ppdb.users.decline_or_cancel_payment', [
                        'ppdb' => $ppdbUser->ppdb,
                        'ppdb_user' => $ppdbUser,
                        'transaction' => $transactionItem->transaction
                    ]) }}">
                      @if(! $transactionItem->isPending())
                        Batal {{ $transactionItem->isPaid() ? 'Menerima' : 'Menolak' }} Pembayaran
                      @else
                        Tolak Pembayaran
                      @endif
                  </a>

                  <a href="{{ $transactionItem->transaction->payment->getFirstMediaUrl('proof') }}"
                     target="_blank"
                     class="font-bold text-blue-700 hover:text-blue-800 mt-4">
                    Lihat Bukti Pembayaran
                  </a>
                @endif
              @endif
            </div>
            @if(auth()->user()->isStudent() && $transactionItem->isPending())
              <div class="w-full mt-5">
                <p>Metode Pembayaran: {{ PaymentType::getDescription($transactionItem->transaction->payment_type) }}</p>
                <p>Provider: {{ Str::upper($transactionItem->transaction->provider) }}</p>
                <p>Nomor: {{ $transactionItem->transaction->provider_number }}</p>
                <p>Atas Nama: {{ $transactionItem->transaction->provider_holder_name }}</p>
              </div>
            @elseif(auth()->user()->isSuperAdminOrAdmin() && ! is_null($transactionItem->transaction->payment))
              <div class="w-full mt-5">
                <p>Nomor Rekening: {{ $transactionItem->transaction->payment->provider_number }}</p>
                <p>Atas Nama: {{ $transactionItem->transaction->payment->provider_holder_name }}</p>
                <p>Waktu Pembayaran: {{ $transactionItem->transaction->payment->paid_on->translatedFormat('l, d F Y H:i') }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

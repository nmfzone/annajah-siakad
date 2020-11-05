<div class="row">
  <div class="col-10 mx-auto">
    <div class="card {{ $transactionItem->isPaid() ? 'card-info' : 'card-danger' }}">
      <div class="card-header">
        <h3 class="card-title">Tagihan</h3>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-8 px-10 py-6 bg-gray-200 flex flex-wrap items-start">
            <div class="w-full md:w-1/2">
              <p>{{ $transactionItem->name }}</p>
              <p>{{ $transactionItem->priceFormatted() }}</p>
            </div>
            <div class="w-full md:w-1/2">
              @if(is_null($transactionItem->transaction->payment))
                <a href="{{ sub_route('dashboard.ppdb.users.show_payment', [
                    'ppdb_user' => $ppdbUser,
                    'transaction' => $transactionItem->transaction
                  ]) }}" class="py-2 px-6 bg-blue-600 hover:bg-blue-800 text-white rounded-lg text-center">
                  Unggah Bukti
                </a>
              @else
                @if(!$transactionItem->transaction->isPaid())
                  <div class="py-2 px-6 bg-yellow-600 text-white rounded-lg text-center">
                    Proses Verifikasi
                  </div>
                @else
                  <div class="py-2 px-6 bg-green-600 text-white rounded-lg text-center">
                    Terverifikasi
                  </div>
                @endif
              @endif
            </div>
            <div class="w-full mt-5">
              <p>Metode Pembayaran: {{ PaymentType::getDescription($transactionItem->transaction->payment_type) }}</p>
              <p>Provider: {{ Str::upper($transactionItem->transaction->provider) }}</p>
              <p>Nomor: {{ $transactionItem->transaction->provider_number }}</p>
              <p>Atas Nama: {{ $transactionItem->transaction->provider_holder_name }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

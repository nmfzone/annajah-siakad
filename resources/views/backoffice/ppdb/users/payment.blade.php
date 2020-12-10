@extends('adminlte::page')

@section('title', 'Unggah Bukti Pembayaran')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">PPDB</h1>
  </div>
@endsection

@section('content')
  <div class="row cloak-spinner" v-cloak>
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Unggah Bukti Pembayaran</h3>
        </div>
        <div class="card-body">
          <form method="POST"
                enctype="multipart/form-data"
                action="{{ sub_route('backoffice.ppdb.users.store_payment', [
                    'ppdb' => $ppdbUser->ppdb,
                    'ppdb_user' => $ppdbUser,
                    'transaction' => $transaction
                ]) }}">
            @csrf
            <div class="row">
              <div class="col-md-6 px-md-4">
                <div class="form-group">
                  <label for="provider_holder_name" class="col-form-label">
                    Nama Pengirim <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="provider_holder_name"
                    name="provider_holder_name"
                    required
                    class="form-control @error('provider_holder_name') is-invalid @enderror"
                    value="{{ old('provider_holder_name') }}">

                  @error('provider_holder_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="provider_number" class="col-form-label">
                    Nomor Rekening <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="provider_number"
                    name="provider_number"
                    required
                    class="form-control @error('provider_number') is-invalid @enderror"
                    value="{{ old('provider_number') }}">

                  @error('provider_number')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="payment_date" class="col-form-label">
                    Tanggal Pembayaran <span class="required">*</span>
                  </label>

                  <form-input
                    id="payment_date"
                    date-picker
                    type="text"
                    initial-value="{{ old('payment_date') }}"
                    end-date="{{ now()->format('Y-m-d') }}"
                    @error('payment_date')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    with-add-on
                    add-on-class="fas fa-calendar"
                    name="payment_date"
                    required></form-input>
                </div>

                <div class="form-group">
                  <label for="payment_time" class="col-form-label">
                    Waktu Pembayaran
                  </label>

                  <input
                    type="text"
                    id="payment_time"
                    name="payment_time"
                    data-inputmask-alias="datetime"
                    data-inputmask-inputformat="HH:MM"
                    data-inputmask-placeholder="00:00"
                    class="form-control mask-input @error('payment_time') is-invalid @enderror"
                    value="{{ old('payment_time') }}">

                  @error('payment_time')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="proof_file" class="col-form-label">
                    Bukti Pembayaran <span class="required">*</span>
                  </label>

                  <div class="custom-file">
                    <input
                      type="file"
                      id="proof_file"
                      name="proof_file"
                      required
                      class="custom-file-input @error('proof_file') is-invalid @enderror">

                    <label class="custom-file-label" for="customFile"></label>

                    @error('proof_file')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-12 px-md-4">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-btn fa-save"></i> Simpan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

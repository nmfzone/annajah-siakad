@extends('adminlte::page')

@section('title', 'Tambah PPDB')

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
          <h3 class="card-title">Tambah PPDB</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ sub_route('backoffice.ppdb.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="academic_year_id" class="col-form-label">
                    Tahun Akademik <span class="required">*</span>
                  </label>

                  <academic-year-picker
                    id="academic_year_id"
                    name="academic_year_id"
                    class="from-control @error('academic_year_id') is-invalid @enderror"
                    required></academic-year-picker>

                  @error('academic_year_id')
                    <span class="invalid-feedback" role="alert">
                      <b>{{ $message }}</b>
                    </span>
                  @enderror
                </div>

                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="start_date" class="col-form-label">
                        Tanggal Mulai <span class="required">*</span>
                      </label>

                      <form-input
                        id="start_date"
                        date-picker
                        type="text"
                        initial-value="{{ old('start_date') }}"
                        @error('start_date')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        with-add-on
                        add-on-class="fas fa-calendar"
                        name="start_date"
                        required></form-input>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="start_time" class="col-form-label">
                        Waktu Mulai <span class="required">*</span>
                      </label>

                      <input
                        type="text"
                        id="start_time"
                        name="start_time"
                        required
                        data-inputmask-alias="datetime"
                        data-inputmask-inputformat="HH:MM"
                        data-inputmask-placeholder="00:00"
                        class="form-control mask-input @error('start_time') is-invalid @enderror"
                        value="{{ old('start_time') }}">

                      @error('start_time')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="end_date" class="col-form-label">
                        Tanggal Selesai <span class="required">*</span>
                      </label>

                      <form-input
                        id="end_date"
                        date-picker
                        type="text"
                        initial-value="{{ old('end_date') }}"
                        @error('end_date')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        with-add-on
                        add-on-class="fas fa-calendar"
                        name="end_date"
                        required></form-input>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="end_time" class="col-form-label">
                        Waktu Selesai <span class="required">*</span>
                      </label>

                      <input
                        type="text"
                        id="end_time"
                        name="end_time"
                        required
                        data-inputmask-alias="datetime"
                        data-inputmask-inputformat="HH:MM"
                        data-inputmask-placeholder="00:00"
                        class="form-control mask-input @error('end_time') is-invalid @enderror"
                        value="{{ old('end_time') }}">

                      @error('end_time')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="price" class="col-form-label">
                    Biaya Pendaftaran <span class="required">*</span>
                  </label>

                  <input
                    type="number"
                    id="price"
                    name="price"
                    required
                    class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price') }}">

                  @error('price')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="text-bold mt-8">
                  <h5>Pembayaran</h5>
                </div>

                <div class="form-group">
                  <label for="payment_provider" class="col-form-label">
                    Provider <span class="required">*</span>
                  </label>

                  @php($paymentProviders = App\Enums\PaymentProvider::asTextValueArray())

                  <form-input
                    id="payment_provider"
                    :data='@json($paymentProviders)'
                    select-first-item
                    initial-value="{{ old('payment.provider') }}"
                    type="select"
                    @error('payment.provider')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    name="payment[provider]"
                    required></form-input>
                </div>

                <div class="form-group">
                  <label for="payment_type" class="col-form-label">
                    Jenis Pembayaran <span class="required">*</span>
                  </label>

                  @php($paymentTypes = App\Enums\PaymentType::asTextValueArray())

                  <form-input
                    id="payment_type"
                    :data='@json($paymentTypes)'
                    select-first-item
                    initial-value="{{ old('payment.payment_type') }}"
                    type="select"
                    @error('payment.payment_type')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    name="payment[payment_type]"
                    required></form-input>
                </div>

                <div class="form-group">
                  <label for="payment_provider_number" class="col-form-label">
                    Nomor Provider <span class="required">*</span>
                  </label>

                  <input
                    type="number"
                    id="payment_provider_number"
                    name="payment[provider_number]"
                    required
                    class="form-control @error('payment.provider_number') is-invalid @enderror"
                    value="{{ old('payment.provider_number') }}">

                  @error('payment.provider_number')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="payment_provider_holder_name" class="col-form-label">
                    Nama Pemilik Provider <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="payment_provider_holder_name"
                    name="payment[provider_holder_name]"
                    required
                    class="form-control @error('payment.provider_holder_name') is-invalid @enderror"
                    value="{{ old('payment.provider_holder_name') }}">

                  @error('payment.provider_holder_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <dynamic-form-input
                  :max="2"
                  :initial-values='@json(Arr::wrap(old('contact_persons')))'
                  :errors='@json($errors->get('contact_persons.*'))'>
                  <template #header="data">
                    <div class="text-bold mt-8 flex items-center">
                      <h5>Narahubung</h5>

                      <span
                        class="btn btn-primary text-xs px-2 py-1.5 ml-4"
                        @click="data.addForm"
                        v-if="data.canAddForm">
                        <i class="fa fa-plus"></i>
                      </span>
                    </div>
                  </template>

                  <template #form="data">
                    <div class="flex items-center mt-3">
                      <span class="text-md">Narahubung @{{ data.formIndex+1 }}</span>
                      <span
                        class="btn btn-danger text-xs px-1 py-0.5 ml-2"
                        @click="data.removeForm(data.formIndex)"
                        v-if="data.canRemoveForm">
                        <i class="fa fa-minus"></i>
                      </span>
                    </div>

                    <div class="form-group">
                      <label :for="`contact_persons_name_${data.formIndex}`" class="col-form-label">
                        Nama <span class="required">*</span>
                      </label>

                      <form-input
                        :id="`contact_persons_name_${data.formIndex}`"
                        type="text"
                        :state="data.hasError(`contact_persons.${data.formIndex}.name`)"
                        :error-message="data.getFirstErrorMessage(`contact_persons.${data.formIndex}.name`)"
                        :initial-value="data.getInitialValue(data.formIndex, 'name')"
                        :name="`contact_persons[${data.formIndex}][name]`"
                        required></form-input>
                    </div>

                    <div class="form-group">
                      <label :for="`contact_persons_number_${data.formIndex}`" class="col-form-label">
                        Nomor HP <span class="required">*</span>
                      </label>

                      <form-input
                        :id="`contact_persons_number_${data.formIndex}`"
                        type="number"
                        :state="data.hasError(`contact_persons.${data.formIndex}.number`)"
                        :error-message="data.getFirstErrorMessage(`contact_persons.${data.formIndex}.number`)"
                        :initial-value="data.getInitialValue(data.formIndex, 'number')"
                        :name="`contact_persons[${data.formIndex}][number]`"
                        required></form-input>
                    </div>
                  </template>
                </dynamic-form-input>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-12">
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

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
                    name="academic_year_id"
                    class="from-control @error('academic_year_id') is-invalid @enderror"
                    required></academic-year-picker>

                  @error('academic_year_id')
                  <span class="invalid-feedback" role="alert">
                      <b>{{ $message }}</b>
                    </span>
                  @enderror
                </div>

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

                <div class="form-group">
                  <label for="start_time" class="col-form-label">
                    Waktu Mulai <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="start_time"
                    name="start_time"
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

                <div class="form-group">
                  <label for="end_time" class="col-form-label">
                    Waktu Selesai <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="end_time"
                    name="end_time"
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

@extends('adminlte::page')

@section('title', 'Tambah Tahun Akademik')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Tahun Akademik</h1>
  </div>
@endsection

@section('content')
  <div class="row cloak-spinner" v-cloak>
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Tambah Tahun Akademik</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ sub_route('backoffice.academic_years.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="from" class="col-form-label">
                    Dari <span class="required">*</span>
                  </label>

                  <input
                    type="number"
                    id="from"
                    name="from"
                    required
                    class="form-control @error('from') is-invalid @enderror"
                    value="{{ old('from') }}">

                  @error('from')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="name" class="col-form-label">
                    Sampai <span class="required">*</span>
                  </label>

                  <input
                    type="number"
                    id="to"
                    name="to"
                    required
                    class="form-control @error('to') is-invalid @enderror"
                    value="{{ old('to') }}">

                  @error('to')
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

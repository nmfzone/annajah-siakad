@extends('adminlte::page')

@section('title', 'Detail Tahun Akademik')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Tahun Akademik</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Tahun Akademik</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="slug" class="col-form-label">
                  Dari
                </label>

                <div class="plain-input">
                  {{ $academicYear->from }}
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-form-label">
                  Sampai
                </label>

                <div class="plain-input">
                  {{ $academicYear->to }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

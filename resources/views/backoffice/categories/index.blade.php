@extends('adminlte::page')

@section('title', 'Daftar Kategori')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Manajemen Kategori</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Daftar Kategori</h3>
            </div>
            @can('create', App\Models\Category::class)
              <div class="col-md-6">
                <a href="{{ route('backoffice.categories.create') }}" class="btn btn-secondary float-right">
                  <i class="fa fa-plus"></i> Tambah Kategori
                </a>
              </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          @include('flash::message', ['timer' => 10])

          {!! $dataTable->table() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {!! $dataTable->scripts() !!}
@endpush

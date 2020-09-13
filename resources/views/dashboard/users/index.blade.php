@extends('adminlte::page')

@section('title', "Daftar " . ucwords($userType))

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Manajemen Pengguna</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Daftar {{ ucwords($userType) }}</h3>
            </div>
            @if(auth()->user()->role == Role::ADMIN)
              <div class="col-md-6">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-secondary float-right">
                  <i class="fa fa-plus"></i> Tambah Pengguna
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

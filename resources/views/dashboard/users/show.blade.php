@extends('adminlte::page')

@section('title', 'Detail Pengguna')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Manajemen Pengguna</h1>
  </div>
@endsection

@section('content')
  <div class="row" v-cloak>
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Pengguna</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="name" class="col-form-label">Nama</label>

                <div class="plain-input">
                  {{ $user->name }}
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-form-label">Email</label>

                <div class="plain-input">
                  {{ $user->email ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">No Telepon</label>

                <div class="plain-input">
                  {{ $user->phone ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">Alamat</label>

                <div class="plain-input">
                  {{ $user->address ?? '-' }}
                </div>
              </div>
            </div>

            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Jenis Kelamin
                </label>

                <div class="plain-input">
                  {{ $user->gender ? 'Laki-Laki' : 'Perempuan' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">Jabatan</label>

                <div class="plain-input">
                  {{ Role::getDescription($user->role) }}
                </div>
              </div>
            </div>
          </div>

          @if(Gate::allows('update', $user))
            <div class="form-group mt-5">
              <div class="col-12">
                <div class="float-right">
                  <a href="{{ route('dashboard.users.edit', $user) }}" class="btn btn-info">
                    <i class="fa fa-btn fa-edit"></i> Perbarui
                  </a>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

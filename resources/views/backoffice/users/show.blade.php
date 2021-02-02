@extends('adminlte::page')

@section('title', 'Detail Pengguna')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Pengguna</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Pengguna</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="name" class="col-form-label">
                  Nama Pengguna
                </label>

                <div class="plain-input">
                  {{ $user->username }}
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-form-label">
                  Nama
                </label>

                <div class="plain-input">
                  {{ $user->name }}
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-form-label">
                  Email
                </label>

                <div class="plain-input">
                  {{ value_get($user, 'email', '-') }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  No Telepon
                </label>

                <div class="plain-input">
                  {{ value_get($user, 'phone', '-') }}
                </div>
              </div>

              <div class="form-group">
                <label for="address" class="col-form-label">
                  Alamat
                </label>

                <div class="plain-input">
                  {{ value_get($user, 'address', '-') }}
                </div>
              </div>
            </div>

            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="gender" class="col-form-label">
                  Jenis Kelamin
                </label>

                <div class="plain-input">
                  {{ $user->gender ? 'Laki-Laki' : 'Perempuan' }}
                </div>
              </div>

              <div class="form-group">
                <label for="role" class="col-form-label">
                  Tempat Lahir
                </label>

                <div class="plain-input">
                  {{ value_get($user, 'birth_place', '-') }}
                </div>
              </div>

              <div class="form-group">
                <label for="role" class="col-form-label">
                  Tanggal Lahir
                </label>

                <div class="plain-input">
                  {{ ($date = $user->birth_date) ? $date->format('d-m-Y') : '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="role" class="col-form-label">
                  Jabatan
                </label>

                <div class="plain-input">
                  {{ Role::getDescription($user->role) }}
                </div>
              </div>
            </div>
          </div>

          @if(Gate::allows('update', $user))
            <div class="row mt-5">
              <div class="col-12 px-md-4">
                <a href="{{ route('backoffice.users.edit', $user) }}" class="btn btn-info float-right">
                  <i class="fa fa-btn fa-save"></i> Perbarui
                </a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  @if($user->isStudent() && ! is_main_app())
    @php($profile = $user->studentProfileFor(site()))

    <div class="row" v-cloak>
      <div class="col-10 mx-auto">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              Data Akademik
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 px-md-4">
                <div class="form-group">
                  <label for="no_kk" class="col-form-label">
                    No KK
                  </label>

                  <div class="plain-input">
                    {{ value_get($profile, 'no_kk', '-') }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="previous_school" class="col-form-label">
                    Asal Sekolah
                  </label>

                  <div class="plain-input">
                    {{ value_get($profile, 'previous_school', '-') }}
                  </div>
                </div>
              </div>

              <div class="col-md-6 px-md-4">
                <div class="form-group">
                  <label for="wali_name" class="col-form-label">
                    Nama Wali
                  </label>

                  <div class="plain-input">
                    {{ value_get($profile, 'wali_name', '-') }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="wali_phone" class="col-form-label">
                    Nomor Telefon Wali
                  </label>

                  <div class="plain-input">
                    {{ value_get($profile, 'wali_phone', '-') }}
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-12 px-md-4">
                <a href="{{ route('backoffice.users.edit', $user) }}" class="btn btn-info float-right">
                  <i class="fa fa-btn fa-save"></i> Perbarui
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @elseif(is_main_app() && $user->isNotSuperAdmin())
    <div class="row">
      <div class="col-10 mx-auto">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              Lis Situs
            </h3>
          </div>
          <div class="card-body pt-10">
            @foreach($user->sites as $site)
              <div class="row mb-4">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6">
                      {{ $site->title }}
                    </div>
                    <div class="col-md-6">
                      <a href="{{ route('backoffice.users.show', ['_domain' => $site->domain, 'user' => $user]) }}"
                         class="badge badge-info text-base">
                        {{ $site->domain }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

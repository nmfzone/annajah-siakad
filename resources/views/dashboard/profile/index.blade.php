@extends('adminlte::page')

@section('title', 'Profil Anda')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Profil Anda</h1>
  </div>
@endsection

@section('content')
  <div class="row" v-cloak>
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Profil Anda</h3>
        </div>
        <div class="card-body">
          @include('flash::message', ['timer' => 10])

          <form method="POST" action="{{ sub_route('dashboard.users.update', $user) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="_context" value="profile">

            <div class="row">
              <div class="col-md-6 px-md-4">
                <div class="form-group">
                  <label for="name" class="col-form-label">
                    Nama <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}">

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="email" class="col-form-label">Email</label>

                  <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="password" class="col-form-label">
                    Password
                  </label>

                  <form-input
                    id="password"
                    type="password"
                    @error('password')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    name="password"
                    autocomplete="password"
                    note="Kosongkan jika tidak ingin memperbarui password."
                    with-add-on></form-input>
                </div>

                <div class="form-group">
                  <label for="password-confirmation" class="col-form-label">
                    Konfirmasi Password
                  </label>

                  <form-input
                    id="password-confirmation"
                    type="password"
                    @error('password_confirmation')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    name="password_confirmation"
                    autocomplete="password"
                    with-add-on></form-input>
                </div>

                <div class="form-group">
                  <label for="phone" class="col-form-label">No Telefon</label>

                  <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone) }}">

                  @error('phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="phone" class="col-form-label">
                    Jenis Kelamin <span class="required">*</span>
                  </label>

                  <div class="mt-1">
                    <div class="icheck-success">
                      <input
                        type="radio"
                        class="form-control @error('gender') is-invalid @enderror"
                        name="gender"
                        @if(old('gender') == '1' or $user->gender) checked @endif
                        value="1"
                        id="gender1">
                      <label for="gender1">
                        Laki-Laki
                      </label>
                    </div>
                    <div class="icheck-success">
                      <input
                        type="radio"
                        class="form-control @error('gender') is-invalid @enderror"
                        name="gender"
                        @if(old('gender') == '0' or ! $user->gender) checked @endif
                        value="0"
                        id="gender2">
                      <label for="gender2">
                        Perempuan
                      </label>
                    </div>

                    @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="col-md-6 px-md-4">
                <div class="form-group">
                  <label for="birth_place" class="col-form-label">
                    Tempat Lahir
                  </label>

                  <input
                    type="text"
                    id="birth_place"
                    name="birth_place"
                    class="form-control @error('birth_place') is-invalid @enderror"
                    value="{{ old('birth_place', $user->birth_place) }}">

                  @error('birth_place')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="birth_date" class="col-form-label">
                    Tanggal Lahir
                  </label>

                  <form-input
                    id="birth_date"
                    date-picker
                    type="text"
                    initial-value="{{ old('birth_date', optional($user->birth_date)->format('d-m-Y')) }}"
                    end-date="{{ now()->format('Y-m-d') }}"
                    @error('birth_date')
                    :state="false"
                    error-message="{{ $message }}"
                    @enderror
                    with-add-on
                    add-on-class="fas fa-calendar"
                    name="birth_date"></form-input>
                </div>

                <div class="form-group">
                  <label for="phone" class="col-form-label">Alamat</label>

                  <textarea
                    rows="3"
                    id="address"
                    name="address"
                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>

                  @error('phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="phone" class="col-form-label">Jabatan</label>

                  <div class="plain-input">
                    {{ Role::getDescription($user->role) }}
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-12 px-md-4">
                <button type="submit" class="btn btn-info float-right">
                  <i class="fa fa-btn fa-save"></i> Perbarui Profil
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

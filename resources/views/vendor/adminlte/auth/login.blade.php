@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Login')

@php
  $login_url = [
    'loc' => View::getSection('login_loc') ?? config('adminlte.login_url.loc', 'main'),
    'path' => View::getSection('login_url') ?? config('adminlte.login_url.path', 'login')
  ];

  $register_url = [
    'loc' => View::getSection('register_loc') ?? config('adminlte.register_url.loc', 'main'),
    'path' => View::getSection('register_url') ?? config('adminlte.register_url.path', 'register')
  ];

  $password_reset_url = [
    'loc' => View::getSection('password_reset_loc') ?? config('adminlte.password_reset_url.loc', 'main'),
    'path' => View::getSection('password_reset_url') ?? config('adminlte.password_reset_url.path', 'password/reset')
  ];
@endphp

@if (config('adminlte.use_route_url', false))
  @php( $login_url = $login_url['path'] ? switch_route($login_url['loc'], $login_url['path']) : '' )
  @php( $register_url = $register_url['path'] ? switch_route($register_url['loc'], $register_url['path']) : '' )
  @php( $password_reset_url = $password_reset_url['path'] ? switch_route($password_reset_url['loc'], $password_reset_url['path']) : '' )
@else
  @php( $login_url = $login_url['path'] ? url($login_url['path']) : '' )
  @php( $register_url = $register_url['path'] ? url($register_url['path']) : '' )
  @php( $password_reset_url = $password_reset_url['path'] ? url($password_reset_url['path']) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
  <form action="{{ $login_url }}" method="post">
    {{ csrf_field() }}
    {{ next_field() }}

    <div class="input-group mb-3">
      <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
             value="{{ old('username') }}" placeholder="Username" autofocus>
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-user"></span>
        </div>
      </div>
      @error('username')
        <div class="invalid-feedback">
          <strong>{{ $message }}</strong>
        </div>
      @enderror
    </div>

    <div class="form-stack mb-3">
      <form-input
        id="password"
        type="password"
        @error('password')
        :state="false"
        error-message="{{ $message }}"
        @enderror
        name="password"
        autocomplete="password"
        placeholder="Password"
        with-add-on required></form-input>
    </div>

    <div class="row">
      <div class="col-7">
        <div class="icheck-primary">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
        </div>
      </div>
      <div class="col-5">
        <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
          <span class="fas fa-sign-in-alt"></span>
          {{ __('adminlte::adminlte.sign_in') }}
        </button>
      </div>
    </div>
  </form>
@stop

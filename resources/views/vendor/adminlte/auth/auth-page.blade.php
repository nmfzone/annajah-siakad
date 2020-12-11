@extends('adminlte::master')

@section('adminlte_css')
  @stack('css')
  @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
  <div class="{{ $auth_type ?? 'login' }}-box">
    <div class="{{ $auth_type ?? 'login' }}-logo">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" class="m-auto" width="180px" />

        <div class="text-2lg mt-3">
          {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
        </div>
      </a>
    </div>

    <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
      @hasSection('auth_header')
        <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
          <h3 class="card-title float-none text-center">
            @yield('auth_header')
          </h3>
        </div>
      @endif

      <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
        @yield('auth_body')
      </div>

      @hasSection('auth_footer')
        <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
          @yield('auth_footer')
        </div>
      @endif
    </div>
  </div>
@stop

@section('adminlte_js')
  @stack('js')
  @yield('js')
@stop

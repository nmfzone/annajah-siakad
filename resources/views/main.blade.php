@extends('layouts.web')

@push('stylesheets')
  <style>
    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }
  </style>
@endpush

@section('content-lv2')
  <div class="font-light text-base">
    <div class="top-right links">
      @auth
        @if(! is_main_app() || (is_main_app() && in_array(Auth::user()->role, [Role::SUPERADMIN, Role::EDITOR])))
          <a href="{{ switch_route('auto', 'backoffice.dashboard') }}">Dashboard</a>
        @endif
      @else
        <a href="{{ main_route('login', ! is_main_app() ? ['next' => sub_route('backoffice.dashboard')] : []) }}">Masuk</a>
      @endauth
    </div>

    <div class="w-full mb-6">
      <div class="flex justify-center">
        <img src="{{ asset('images/logo.png') }}" class="w-1/4" />
      </div>

      <h4 class="text-3xl md:text-4xl mt-4 mb-5 text-center">
        {{ Site::title() }}
      </h4>
    </div>
  </div>
@endsection

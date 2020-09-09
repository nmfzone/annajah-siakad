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
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      @else
        <a href="{{ route('login') }}">Masuk</a>
      @endauth
    </div>

    <div class="w-full mb-6">
      <div class="flex justify-center">
        <img src="{{ asset('images/logo.png') }}" class="w-1/4" />
      </div>

      <h3 class="font-normal text-3xl md:text-4xl mb-1 text-center mt-4">
        Sistem Presensi
      </h3>

      <h4 class="text-lg md:text-xl mb-5 text-center">
        {{ config('app.name') }}
      </h4>
    </div>
  </div>
@endsection

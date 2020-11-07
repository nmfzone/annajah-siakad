@extends('layouts.base')

@section('content')
  <div class="bg-gray-100 container-full cf-pt-10 cf-pb-10 cf-ptol-20 bg-cover bg-scroll font-exo">
    <div class="{{ $width ?? 'md:w-4/6 lg:w-1/2' }} mx-5">
      @yield('top-content-lv2')

      <div class="w-full md:mx-auto px-10 rounded-lg px-10 py-8 {{ $background ?? 'bg-t-white-90 md:bg-t-white-70' }}">
        @yield('content-lv2')
      </div>
    </div>
  </div>
@endsection

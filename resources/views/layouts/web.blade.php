@extends('layouts.base')

@push('stylesheets')
  <link href='https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;600' rel='stylesheet' type='text/css'>
@endpush

@section('content')
  <div class="bg-gray-100 container-full cf-pt-10 cf-pb-10 cf-ptol-20 bg-cover bg-scroll font-exo">
    <div class="{{ $width ?? 'md:w-4/6 lg:w-1/2' }} md:mx-auto mx-5 px-10 rounded-lg px-10 py-8 bg-t-white-90 md:bg-t-white-70">
      @yield('content-lv2')
    </div>
  </div>
@endsection

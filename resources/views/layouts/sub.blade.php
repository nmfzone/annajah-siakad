@extends('layouts.base')

@section('content')
  <header class="bg-transparent w-full">
    <div class="main-navbar w-full">
      <div class="sm:px-8 lg:px-16 xl:px-40 2xl:px-64 px-4 font-semibold">
        <nav class="flex items-center justify-between">
          <div class="logo-box">
            <a href="{{ url('/') }}" class="logo btw">
              <img src="{{ asset('images/logo.png') }}" alt="{{ app_name() }}">
              <span>{{ app_name() }}</span>
            </a>
          </div>

          <div class="block sm:hidden">
            <button type="button" class="navbar-toggler">
              <span class="navbar-toggler-bar"></span>
              <span class="navbar-toggler-bar"></span>
              <span class="navbar-toggler-bar"></span>
            </button>
          </div>

          <div class="hidden sm:flex">
            <div class="uppercase text-sm">
              <navbar-menu li-class-root="mx-5 py-6-imp" :data='@json($menus)'></navbar-menu>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>
  <div class="w-full mb-10">
    <carousel :slides='@json($slides)' slide-height="90vh"></carousel>
  </div>

  @yield('content-lv2')

  <footer class="relative text-white px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 pt-12 pb-10 text-center sm:text-left">
    <div class="flex flex-col sm:flex-row sm:flex-wrap">
      <div class="sm:w-1/2 lg:w-1/5">
        <h6 class="text-sm font-bold uppercase">Menu</h6>
        <ul class="mt-4 list-unstyled text-gray-300">
          <li class="hover:text-white"><a href="#">Resources</a></li>
          <li class="mt-2 hover:text-white"><a href="#">Careers</a></li>
        </ul>
      </div>

      <div class="mt-8 sm:w-1/2 sm:mt-0 lg:w-1/5 lg:mt-0">
        <h6 class="text-sm font-bold uppercase">Sosial Media</h6>
        <ul class="mt-4 list-unstyled text-gray-300">
          <li class="hover:text-white"><a href="#">Instagram</a></li>
          <li class="mt-2 hover:text-white"><a href="#">Twitter</a></li>
          <li class="mt-2 hover:text-white"><a href="#">Facebook</a></li>
        </ul>
      </div>

      <div class="mt-8 sm:w-1/2 sm:mt-12 lg:w-1/5 lg:mt-0">
        <h6 class="text-sm font-bold uppercase">Situs</h6>
        <ul class="mt-4 list-unstyled text-gray-300">
          <li class="hover:text-white"><a href="#">Todo</a></li>
          <li class="mt-2 hover:text-white"><a href="#">Done</a></li>
        </ul>
      </div>

      <div class="mt-12 sm:w-1/2 lg:w-2/5 lg:mt-0 lg:pl-12">
        <div class="w-full">
          <img src="{{ asset('images/logo.png') }}" alt="{{ app_name() }}" class="w-32">
        </div>

        <div class="text-base mt-4">
          <b>{{ app_name() }}</b>
          <div class="flex py-1">
            <span class="pr-2">
              <i class="fa fa-map-marker"></i>
            </span>
            <p>{{ $site->address }}</p>
          </div>
          <div class="flex py-1">
            <span class="pr-2">
              <i class="fa fa-envelope"></i>
            </span>
            <p>{{ $site->email }}</p>
          </div>
          <div class="flex py-1">
            <span class="pr-2">
              <i class="fa fa-phone"></i>
            </span>
            <p>{{ $site->phone }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8">
      <hr class="mb-8">
      <p class="text-sm">2020 © {{ app_name() }}. All rights reserved.</p>
    </div>
  </footer>
@endsection

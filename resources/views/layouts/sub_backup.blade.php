@extends('layouts.base')

@section('content')
  <header class="bg-transparent w-full">
    <div class="main-navbar w-full">
      <div class="h-full sm:px-8 lg:px-16 xl:px-40 2xl:px-64 px-4 font-semibold">
        <nav class="h-full flex items-center justify-between">
          <div class="logo-box">
            <a href="{{ url('/') }}" class="logo btw text-xs md:text-sm">
              <img src="{{ Site::logo() }}" alt="{{ Site::title() }}">
              <span>{{ Site::title() }}</span>
            </a>
          </div>

          <navbar-menu li-class-root="py-4.05-imp md:py-6-imp" :data='@json(Site::menus())'></navbar-menu>
        </nav>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    @yield('content-lv2')

    <footer class="relative text-white px-4 mt-20 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 pt-12 pb-10 text-left">
      <div class="flex flex-col sm:flex-row sm:flex-wrap">
        <div class="sm:w-1/2 lg:w-1/5 px-6 md:px-0">
          <h6 class="text-sm font-bold uppercase">Menu</h6>
          <ul class="mt-4 list-unstyled text-gray-300">
            <li class="hover:text-white"><a href="#">Resources</a></li>
            <li class="mt-2 hover:text-white"><a href="#">Careers</a></li>
          </ul>
        </div>

        <div class="mt-8 sm:w-1/2 sm:mt-12 lg:w-1/5 lg:mt-0 px-6 md:px-0">
          <h6 class="text-sm font-bold uppercase">Situs</h6>
          <ul class="mt-4 list-unstyled text-gray-300">
            <li class="hover:text-white"><a href="#">Todo</a></li>
            <li class="mt-2 hover:text-white"><a href="#">Done</a></li>
          </ul>
        </div>

        <div class="mt-8 sm:w-1/2 sm:mt-12 lg:w-1/5 lg:mt-0 px-6 md:px-0">
          <h6 class="text-sm font-bold uppercase">Media Sosial</h6>
          <ul class="mt-4 list-unstyled text-gray-300">
            @if(Site::hasInstagram())
              <li class="hover:text-red-700 text-xl">
                <a href="{{ Site::instagram() }}"><i class="fab fa-instagram mr-2"></i> Instagram</a>
              </li>
            @endif
            @if(Site::hasFacebook())
              <li class="hover:text-blue-800 mt-4 text-xl">
                <a href="{{ Site::facebook() }}"><i class="fab fa-facebook mr-2"></i> Facebook</a>
              </li>
            @endif
            @if(Site::hasTwitter())
              <li class="hover:text-blue-400 mt-4 text-xl">
                <a href="{{ Site::twitter() }}"><i class="fab fa-twitter mr-2"></i> Twitter</a>
              </li>
            @endif
          </ul>
        </div>

        <div class="mt-12 sm:w-1/2 lg:w-2/5 lg:mt-0 lg:pl-12 px-6 md:px-0">
          <div class="w-full">
            <img src="{{ Site::logo() }}" alt="{{ Site::title() }}" class="w-32">
          </div>

          <div class="text-base mt-4">
            <b>{{ Site::title() }}</b>
            <div class="flex py-1">
              <span class="pr-2">
                <i class="fa fa-map-marker"></i>
              </span>
              <p>{{ Site::address() }}</p>
            </div>
            <div class="flex py-1">
              <span class="pr-2">
                <i class="fa fa-envelope"></i>
              </span>
              <p>{{ Site::email() }}</p>
            </div>
            <div class="flex py-1">
              <span class="pr-2">
                <i class="fa fa-phone"></i>
              </span>
              <p>{{ Site::phone() }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8 px-6 md:px-0">
        <hr class="mb-8">
        <p class="text-sm">2020 © {{ Site::title() }}. All rights reserved.</p>
      </div>
    </footer>
  </div>
@endsection

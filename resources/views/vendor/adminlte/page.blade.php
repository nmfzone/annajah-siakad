@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if ($layoutHelper->isLayoutTopnavEnabled())
  @php( $def_container_class = 'container' )
@else
  @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
  @stack('css')
  @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
  <div class="wrapper">
    @if ($layoutHelper->isLayoutTopnavEnabled())
      @include('adminlte::partials.navbar.navbar-layout-topnav')
    @else
      @include('adminlte::partials.navbar.navbar')
    @endif

    @if (! $layoutHelper->isLayoutTopnavEnabled())
      @include('adminlte::partials.sidebar.left-sidebar')
    @endif

    <div class="content-wrapper pt-4 pb-4 {{ config('adminlte.classes_content_wrapper') ?? '' }}">
      <div class="content-header">
        <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
          @yield('content_header')
        </div>
      </div>

      <div class="content">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
          @yield('content')
        </div>
      </div>
    </div>

    @include('adminlte::partials.footer.footer')

    @if (config('adminlte.right_sidebar'))
      @include('adminlte::partials.sidebar.right-sidebar')
    @endif
  </div>
@stop

@section('adminlte_js')
  @stack('js')
  @yield('js')
@stop

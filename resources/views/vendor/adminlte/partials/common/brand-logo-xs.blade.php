@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<div class="d-inline-block w-100">
  <a href="{{ $dashboard_url }}"
      @if($layoutHelper->isLayoutTopnavEnabled())
          class="navbar-brand {{ config('adminlte.classes_brand') }} d-inline-block w-100"
      @else
          class="brand-link {{ config('adminlte.classes_brand') }} d-inline-block w-100"
      @endif>

      {{-- Small brand logo --}}
      <img src="{{ asset('images/logo.png') }}"
           alt="{{ config('app.name') }}"
           class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}"
           style="opacity:.8">

      {{-- Brand text --}}
      <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
          Sistem Akademik
      </span>

  </a>
</div>

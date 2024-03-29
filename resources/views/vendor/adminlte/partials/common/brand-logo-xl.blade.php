@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@php
  $dashboard_url = [
    'loc' => View::getSection('dashboard_loc') ?? config('adminlte.dashboard_url.loc', 'main'),
    'path' => View::getSection('dashboard_url') ?? config('adminlte.dashboard_url.path', 'home')
  ];
@endphp

@if (config('adminlte.use_route_url', false))
  @php( $dashboard_url = $dashboard_url['path'] ? switch_route($dashboard_url['loc'], $dashboard_url['path']) : '' )
@else
  @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand logo-switch"
    @else
        class="brand-link logo-switch"
    @endif>

    {{-- Small brand logo --}}
    <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('adminlte.logo_img_class', 'brand-image-xl') }} logo-xs">

    {{-- Large brand logo --}}
    <img src="{{ asset(config('adminlte.logo_img_xl')) }}"
         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('adminlte.logo_img_xl_class', 'brand-image-xs') }} logo-xl">

</a>

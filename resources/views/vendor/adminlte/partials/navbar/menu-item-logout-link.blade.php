@php
  $logout_url = [
    'loc' => View::getSection('logout_loc') ?? config('adminlte.logout_url.loc', 'main'),
    'path' => View::getSection('logout_url') ?? config('adminlte.logout_url.path', 'logout')
  ];
@endphp

@if (config('adminlte.use_route_url', false))
  @php( $logout_url = $logout_url['path'] ? switch_route($logout_url['loc'], $logout_url['path']) : '' )
@else
  @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li class="nav-item">
  <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa fa-fw fa-power-off"></i>
    {{ __('adminlte::adminlte.log_out') }}
  </a>
  <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
    @if(config('adminlte.logout_method'))
      {{ method_field(config('adminlte.logout_method')) }}
    @endif
    {{ csrf_field() }}
  </form>
</li>

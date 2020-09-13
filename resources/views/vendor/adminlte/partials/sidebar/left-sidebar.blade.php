<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">
  @if (config('adminlte.logo_img_xl'))
    @include('adminlte::partials.common.brand-logo-xl')
  @else
    @include('adminlte::partials.common.brand-logo-xs')
  @endif

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
        data-widget="treeview" role="menu"
        @if(config('adminlte.sidebar_nav_animation_speed') != 300)
          data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
        @endif
        @if(! config('adminlte.sidebar_nav_accordion'))
          data-accordion="false"
        @endif>

        @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')

        @if(auth()->user()->isNotStudent())
          <li class="nav-item has-treeview
                    {{ Request::is('pengguna/*') ? 'menu-open' :'' }}">
            <a class="nav-link
                    {{ Request::is('pengguna/*') ? 'active' :'' }}"
               href="#">
              <i class="fa fa-fw fa-users"></i>

              <p>Manajemen Pengguna <i class="fas fa-angle-left right"></i></p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link
                        {{ Request::is('pengguna/all/asatidz') ? 'active' :'' }}"
                   href="{{ route('dashboard.users.index', 'asatidz') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Daftar Asatidz</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link
                        {{ Request::is('pengguna/all/santri') ? 'active' :'' }}"
                   href="{{ route('dashboard.users.index', 'santri') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Daftar Santri</p>
                </a>
              </li>
            </ul>
          </li>
        @endif

        <li class="nav-header">
          PENGATURAN AKUN
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user"></i>
            <p>Profil</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

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
          @if (!is_main_app())
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
                     href="{{ sub_route('dashboard.users.index', 'asatidz') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Daftar Asatidz</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link
                          {{ Request::is('pengguna/all/santri') ? 'active' :'' }}"
                     href="{{ sub_route('dashboard.users.index', 'santri') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Daftar Santri</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
        @endif

        @if(!is_main_app())
          <li class="nav-item has-treeview
                    {{ Request::is('ppdb/*') ? 'menu-open' :'' }}">
            <a class="nav-link
                    {{ Request::is('ppdb/*') ? 'active' :'' }}"
               href="#">
              <i class="fa fa-fw fa-clipboard"></i>
              <p>PPDB <i class="fas fa-angle-left right"></i></p>
            </a>

            <ul class="nav nav-treeview">
              @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link
                          {{ Request::is('ppdb/peserta') ? 'active' :'' }}"
                     href="{{ sub_route('dashboard.ppdb.users.index') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Lis Pendaftar</p>
                  </a>
                </li>
              @endif
              @if(App\Models\PpdbUser::where('user_id', auth()->user()->id)->exists())
                <li class="nav-item">
                  <a class="nav-link
                          {{ Request::is('ppdb/peserta/detail', 'ppdb/peserta/*') ? 'active' :'' }}"
                     href="{{ sub_route('dashboard.ppdb.users.direct_show') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Detail Pendaftaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link
                        {{ Request::is('ppdb/observasi', 'ppdb/observasi/*') ? 'active' :'' }}"
                     href="{{ sub_route('dashboard.ppdb.observation.index') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Observasi</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
        @endif

        <li class="nav-header">
          PENGATURAN AKUN
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ switch_route('auto', 'dashboard.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <p>Profil</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

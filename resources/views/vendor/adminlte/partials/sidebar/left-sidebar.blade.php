<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">
  @if(config('adminlte.logo_img_xl'))
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

        @can('viewAny', App\Models\User::class)
          <li class="nav-item has-treeview
                    {{ Request::is('backoffice/pengguna/*') ? 'menu-open' :'' }}">
            <a class="nav-link
                    {{ Request::is('backoffice/pengguna/*') ? 'active' :'' }}"
               href="#">
              <i class="fa fa-fw fa-users"></i>

              <p>Pengguna <i class="fas fa-angle-left right"></i></p>
            </a>

            <ul class="nav nav-treeview">
              @can('viewAny', [App\Models\User::class, 'administrator+editor'])
                <li class="nav-item">
                  <a class="nav-link
                          {{ Request::is('backoffice/pengguna/all/administrator+editor') ? 'active' :'' }}"
                     href="{{ route('backoffice.users.index', 'administrator+editor') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Lis Admin & Editor</p>
                  </a>
                </li>
              @endif
              <li class="nav-item">
                <a class="nav-link
                        {{ Request::is('backoffice/pengguna/all/asatidz') ? 'active' :'' }}"
                   href="{{ route('backoffice.users.index', 'asatidz') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Lis Asatidz</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link
                        {{ Request::is('backoffice/pengguna/all/santri') ? 'active' :'' }}"
                   href="{{ route('backoffice.users.index', 'santri') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Lis Santri</p>
                </a>
              </li>
            </ul>
          </li>
        @endif

        @if(!is_main_app())
          @if(Gate::allows('viewAny', App\Models\Ppdb::class) || ! is_null($latestPpdbUser))
            <li class="nav-item has-treeview
                      {{ Request::is('backoffice/ppdb', 'backoffice/ppdb/*') ? 'menu-open' :'' }}">
              <a class="nav-link
                      {{ Request::is('backoffice/ppdb', 'backoffice/ppdb/*') ? 'active' :'' }}"
                 href="#">
                <i class="fa fa-fw fa-clipboard"></i>
                <p>PPDB <i class="fas fa-angle-left right"></i></p>
              </a>

              <ul class="nav nav-treeview">
                @if(isset($currentPpdb) && Gate::allows('viewAny', App\Models\PpdbUser::class))
                  <li class="nav-item">
                    <a class="nav-link
                            {{ Request::is('backoffice/ppdb/*/peserta') ? 'active' :'' }}"
                       href="{{ sub_route('backoffice.ppdb.users.index', $currentPpdb) }}">
                      <i class="far fa-fw fa-circle"></i>
                      <p>Lis Peserta Terkini</p>
                    </a>
                  </li>
                @endif
                @if(Gate::allows('viewAny', App\Models\Ppdb::class))
                  <li class="nav-item">
                    <a class="nav-link
                          {{ Request::is('backoffice/ppdb') ? 'active' :'' }}"
                       href="{{ sub_route('backoffice.ppdb.index') }}">
                      <i class="far fa-fw fa-circle"></i>
                      <p>Lis PPDB</p>
                    </a>
                  </li>
                @endif
                @if(! is_null($latestPpdbUser))
                  <li class="nav-item">
                    <a class="nav-link
                            {{ Request::is('backoffice/ppdb/peserta/detail', 'backoffice/ppdb/*/peserta/*') ? 'active' :'' }}"
                       href="{{ sub_route('backoffice.ppdb.users.direct_show') }}">
                      <i class="far fa-fw fa-circle"></i>
                      <p>Detail Pendaftaran</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link
                          {{ Request::is('backoffice/ppdb/observasi') ? 'active' :'' }}"
                       href="{{ sub_route('backoffice.ppdb.observation.direct_show') }}">
                      <i class="far fa-fw fa-circle"></i>
                      <p>Observasi</p>
                    </a>
                  </li>
                @endif
              </ul>
            </li>
          @endif
        @endif

        @can('viewAny', App\Models\Article::class)
          <li class="nav-item has-treeview
                      {{ Request::is('backoffice/artikel', 'backoffice/artikel/*', 'backoffice/kategori', 'backoffice/kategori/*') ? 'menu-open' :'' }}">
            <a class="nav-link
                      {{ Request::is('backoffice/artikel', 'backoffice/artikel/*', 'backoffice/kategori', 'backoffice/kategori/*') ? 'active' :'' }}"
               href="#">
              <i class="fas fa-fw fa-newspaper"></i>
              <p>Artikel <i class="fas fa-angle-left right"></i></p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link
                          {{ Request::is('backoffice/artikel/buat') ? 'active' :'' }}"
                   href="{{ route('backoffice.articles.create') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Tambah Artikel</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link
                          {{ Request::is('backoffice/artikel') ? 'active' :'' }}"
                   href="{{ route('backoffice.articles.index') }}">
                  <i class="far fa-fw fa-circle"></i>
                  <p>Lis Artikel</p>
                </a>
              </li>
              @can('viewAny', App\Models\Category::class)
                <li class="nav-item">
                  <a class="nav-link
                            {{ Request::is('backoffice/kategori') ? 'active' :'' }}"
                     href="{{ route('backoffice.categories.index') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Lis Kategori</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
        @endif

        @if(Gate::allows('viewAny', App\Models\AcademicYear::class))
          <li class="nav-header">
            PENGATURAN SITUS
          </li>
        @endif

        @if(!is_main_app())
          @can('viewAny', App\Models\AcademicYear::class)
            <li class="nav-item has-treeview
                        {{ Request::is('backoffice/tahun-akademik', 'backoffice/tahun-akademik/*') ? 'menu-open' :'' }}">
              <a class="nav-link
                        {{ Request::is('backoffice/tahun-akademik', 'backoffice/tahun-akademik/*') ? 'active' :'' }}"
                 href="#">
                <i class="fas fa-fw fa-newspaper"></i>
                <p>Tahun Akademik <i class="fas fa-angle-left right"></i></p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a class="nav-link
                            {{ Request::is('backoffice/tahun-akademik/buat') ? 'active' :'' }}"
                     href="{{ sub_route('backoffice.academic_years.create') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Tambah Tahun Akademik</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link
                            {{ Request::is('backoffice/tahun-akademik') ? 'active' :'' }}"
                     href="{{ sub_route('backoffice.academic_years.index') }}">
                    <i class="far fa-fw fa-circle"></i>
                    <p>Lis Tahun Akademik</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
        @endif

        <li class="nav-header">
          PENGATURAN AKUN
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('backoffice.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <p>Profil</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

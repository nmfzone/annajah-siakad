@extends('adminlte::page')

@section('title', 'Detail Peserta PPDB')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">PPDB</h1>
  </div>
@endsection

@section('content')
  @if(!$transactionItem->isPaid())
    @include('dashboard.ppdb.partials.invoices')
  @endif

  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Detail Peserta PPDB</h3>
            </div>
            <div class="col-md-6">
              <a href="{{ auth()->user()->isSuperAdminOrAdmin()
                            ? sub_route('dashboard.users.edit', $ppdbUser->user)
                            : sub_route('dashboard.profile') }}"
                 class="btn btn-secondary float-right">
                <i class="fas fa-edit"></i> Ubah
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          @include('flash::message', ['timer' => 10])

          <div class="row">
            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="name" class="col-form-label">Nama Pengguna</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->username }}
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-form-label">Nama</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->name }}
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-form-label">Nama Panggilan</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->nickname ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-form-label">Email</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->email ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">No Telepon</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->phone ?? '-' }}
                </div>
              </div>
            </div>

            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Jenis Kelamin
                </label>

                <div class="plain-input">
                  {{ $ppdbUser->user->gender ? 'Laki-Laki' : 'Perempuan' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Tempat Lahir
                </label>

                <div class="plain-input">
                  {{ $ppdbUser->user->birth_place ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Tanggal Lahir
                </label>

                <div class="plain-input">
                  {{ ($date = $ppdbUser->user->birth_date) ? $date->format('d-m-Y') : '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">Alamat</label>

                <div class="plain-input">
                  {{ $ppdbUser->user->address ?? '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Pendaftaran PPDB</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 px-md-4">
              @php($profile = $ppdbUser->user->studentProfileFor(Site::model()))

              <div class="form-group">
                <label for="phone" class="col-form-label">No Kartu Keluarga</label>

                <div class="plain-input">
                  {{ $profile->no_kk ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Nama Wali
                </label>

                <div class="plain-input">
                  {{ $profile->wali_name ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  No Telefon Wali
                </label>

                <div class="plain-input">
                  {{ $profile->wali_phone ?? '-' }}
                </div>
              </div>
            </div>

            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Asal Sekolah
                </label>

                <div class="plain-input">
                  {{ $profile->previous_school ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Jalur Pendaftaran
                </label>

                <div class="plain-input">
                  {{ SelectionMethod::getDescription($ppdbUser->selection_method) }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Waktu Pendaftaran
                </label>

                <div class="plain-input">
                  {{ $ppdbUser->created_at->translatedFormat('l, d F Y') }} pukul {{ $ppdbUser->created_at->format('H:i') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($transactionItem->isPaid())
    @include('dashboard.ppdb.partials.invoices')
  @endif
@endsection
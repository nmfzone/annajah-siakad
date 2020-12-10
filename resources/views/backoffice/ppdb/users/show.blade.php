@extends('adminlte::page')

@section('title', 'Detail Peserta PPDB')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">PPDB</h1>
  </div>
@endsection

@section('content')
  @if(! $transactionItem->isPaid())
    @include('backoffice.ppdb.users.partials.invoices')
  @endif

  @php
    $student = $ppdbUser->user->studentProfileFor(site());
  @endphp

  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Detail Peserta PPDB</h3>
            </div>
            <div class="col-md-6 flex justify-end">
              @if(Gate::allows('acceptAsStudent', $ppdbUser) && ! ($student->isAccepted() || $student->isDeclined()))
                <a class="btn btn-success submit-this"
                   data-message="Apakah Anda yakin akan menerima peserta ini?"
                   href="{{ sub_route('backoffice.ppdb.users.accept', [
                      'ppdb' => $ppdbUser->ppdb,
                      'ppdb_user' => $ppdbUser,
                  ]) }}">
                  Terima {{ Role::getDescription(Role::STUDENT) }}
                </a>
              @endif
              @if(Gate::allows('declineOrCancelAsStudent', $ppdbUser))
                <a class="btn btn-danger ml-2 submit-this"
                   data-message="{{ $student->isAccepted() || $student->isDeclined()
                      ? 'Apakah Anda yakin akan membatalkan ' . ($student->isAccepted() ? 'penerimaan' : 'penolakan') . ' peserta ini?'
                      : 'Apakah Anda yakin akan menolak peserta ini?' }}"
                   href="{{ sub_route('backoffice.ppdb.users.decline_or_cancel', [
                      'ppdb' => $ppdbUser->ppdb,
                      'ppdb_user' => $ppdbUser,
                  ]) }}">
                  @if($student->isAccepted() || $student->isDeclined())
                    Batal {{ $student->isAccepted() ? 'Terima' : 'Tolak' }} {{ Role::getDescription(Role::STUDENT) }}
                  @else
                    Tolak {{ Role::getDescription(Role::STUDENT) }}
                  @endif
                </a>
              @endif
              <a href="{{ auth()->user()->isSuperAdminOrAdmin()
                    ? route('backoffice.users.edit', ['user' => $ppdbUser->user, 'to_previous' => 1])
                    : route('backoffice.profile') }}"
                 class="ml-2 btn btn-secondary">
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
              <div class="form-group">
                <label for="phone" class="col-form-label">No Kartu Keluarga</label>

                <div class="plain-input">
                  {{ $student->no_kk ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Nama Wali
                </label>

                <div class="plain-input">
                  {{ $student->wali_name ?? '-' }}
                </div>
              </div>

              <div class="form-group">
                <label for="phone" class="col-form-label">
                  No Telefon Wali
                </label>

                <div class="plain-input">
                  {{ $student->wali_phone ?? '-' }}
                </div>
              </div>
            </div>

            <div class="col-md-6 px-md-4">
              <div class="form-group">
                <label for="phone" class="col-form-label">
                  Asal Sekolah
                </label>

                <div class="plain-input">
                  {{ $student->previous_school ?? '-' }}
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
    @include('backoffice.ppdb.users.partials.invoices')
  @endif
@endsection

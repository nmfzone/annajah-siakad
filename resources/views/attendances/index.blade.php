@extends('layouts.web', [
  'background' => 'bg-gray-200',
])

@section('title', "Presensi Kehadiran")

@section('top-content-lv2')
  <div class="text-center">
    <div class="flex justify-center">
      <img src="{{ asset('images/logo.png') }}" class="w-1/4" />
    </div>

    <h3 class="font-normal text-2xl md:text-3xl mb-5">
      Presensi Kehadiran
    </h3>
  </div>
@endsection

@section('content-lv2')
  <div class="font-light text-base">
    <div class="w-full lg:w-5/6 mb-6 mx-auto">
      <div class="text-center">
        @include('flash::message', ['dismissible' => true, 'timer' => 0])

        <div class="mt-5">
          <form id="next-form" action="{{ sub_route('attendances.store') }}" method="POST">
            @csrf

            <h3 class="font-normal text-lg mb-5 text-center">
              Pilih Jenis Presensi
            </h3>

            <div class="form-stack mb-5">
              <form-select
                name="attendance"
                :options='@json($attendances)'
                class="@error('email') is-invalid @enderror"
                no-options-message="Presensi Kehadiran kosong."
                label="label"
                value-key="value"></form-select>

              @error('attendance')
                <span class="invalid-feedback" role="alert">
                  <b>{{ $message }}</b>
                </span>
              @enderror
            </div>

            <button class="rounded bg-blue-600 px-4 py-2 text-white text-lg">
              {{ __('Hadir') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

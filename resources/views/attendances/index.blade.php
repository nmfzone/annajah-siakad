@extends('layouts.web')

@section('title', "Presensi {$attendance->name} {$attendance->academicClass->name} {$attendance->academicClass->academicYear->name}")

@section('content-lv2')
  <div class="font-light text-base">
    <div class="w-full mb-6">
      <h3 class="font-normal text-2xl md:text-3xl mb-3 text-center">
        Presensi {{ $attendance->name }}
      </h3>

      <h4 class="text-lg md:text-xl text-center">
        Kelas {{ $attendance->academicClass->name }}
      </h4>

      <h4 class="text-lg md:text-xl mb-5 text-center">
        Tahun Ajaran {{ $attendance->academicClass->academicYear->name }}
      </h4>

      <div class="text-center">
        @include('flash::message')

        @if ($userAttend == null)
          <div class="mt-20">
            <form id="next-form" action="{{ route('attendances.store', $attendance->slug) }}" method="POST">
              @csrf

              <button class="rounded bg-blue-600 px-4 py-2 text-white text-lg">
                {{ __('Hadir') }}
              </button>
            </form>
          </div>

          <div class="mt-4">
            Waktu Presensi berakhir pukul <b>{{ $attendance->ended_at->format('h:i:s') }}</b> WIB
          </div>
        @else
          <div class="divide-y divide-gray-400">
            <div class="pt-4 pb-4">
              Anda telah melakukan presensi pukul <b>{{ $attendTime->format('h:i:s') }}</b> WIB
            </div>

            @if ($attendance->message)
              <div class="pt-4">
                {!! $attendance->message !!}
              </div>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

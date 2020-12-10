@extends('adminlte::page')

@section('title', 'Observasi PPDB')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Observasi</h1>
  </div>
@endsection

@php
  $student = $ppdbUser->user->studentProfileFor(site());
@endphp

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Observasi</h3>
            </div>
          </div>
        </div>
        <div class="card-body">
          @php
            $roleDesc = Role::getDescription(Role::STUDENT);
            $siteTitle = Site::title();
          @endphp
          @if(auth()->user()->isStudent())
            @if($student->isAccepted())
              <alert
                state="success"
                message="{{ "Berdasarkan hasil Observasi yang telah dilakukan, kami memutuskan:<br><br>Selamat, Anda diterima sebagai $roleDesc di $siteTitle." }}"></alert>
            @elseif($student->isDeclined())
              <alert
                state="danger"
                message="{{ "Berdasarkan hasil Observasi yang telah dilakukan, kami memutuskan:<br><br>Anda belum diterima sebagai $roleDesc di $siteTitle" }}."></alert>
            @endif
          @endif

          @if(!$student->isPending())
            <div class="text-center text-lg">
              <p>Observasi PPDB {{ $ppdbUser->ppdb->academicYear->name }}</p>

              <a href="https://forms.gle/fxqn4VJPe6AXj9aX7" class="mt-4 btn btn-primary">
                Klik Disini
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

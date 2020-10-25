@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="m-0 text-dark">Dashboard</h1>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-3 col-6">
      <a href="#">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $teacherCounts }}</h3>

            <p>Total Asatidz</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-tie"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6">
      <a href="#">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $studentCounts }}</h3>

            <p>Total Siswa Aktif</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6">
      <a href="#">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $graduatedStudentCounts }}</h3>

            <p>Total Kelulusan</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-graduate"></i>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <p class="mb-0">You are logged in!</p>
        </div>
      </div>
    </div>
  </div>
@endsection

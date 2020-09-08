@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-blue"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Asatidz</span>
          <span class="info-box-number">{{ $teacherCounts }}</span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Siswa Aktif</span>
          <span class="info-box-number">{{ $studentCounts }}</span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fas fa-user-graduate"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Kelulusan</span>
          <span class="info-box-number">{{ $graducatedStudentCounts }}</span>
        </div>
      </div>
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
@stop

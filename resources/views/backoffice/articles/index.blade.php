@extends('adminlte::page')

@section('title', 'Lis Artikel')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Artikel</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 my-auto">
              <h3 class="card-title">Lis Artikel</h3>
            </div>
            <div class="col-md-6 flex justify-end">
              @can('create', App\Models\Article::class)
                <a href="{{ route('backoffice.articles.create') }}" class="btn btn-secondary">
                  <i class="fa fa-plus"></i> Buat
                </a>
              @endif
              @can('restore', App\Models\Article::class)
                <a href="?onlyTrashed=true" class="btn btn-danger ml-2">
                  Kotak Sampah
                </a>
                <a href="?withTrashed=true" class="btn btn-light text-black-imp ml-2">
                  Semua Artikel
                </a>
              @endif
            </div>
          </div>
        </div>
        <div class="card-body">
          @include('flash::message', ['timer' => 10])

          {!! $dataTable->table() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {!! $dataTable->scripts() !!}
@endpush

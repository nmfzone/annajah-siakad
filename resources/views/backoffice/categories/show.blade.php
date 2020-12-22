@extends('adminlte::page')

@section('title', 'Detail Kategori')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Manajemen Kategori</h1>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Kategori</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="slug" class="col-form-label">
                  Slug
                </label>

                <div class="plain-input">
                  {{ $category->slug }}
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-form-label">
                  Nama Kategori
                </label>

                <div class="plain-input">
                  {{ $category->name }}
                </div>
              </div>
            </div>
          </div>

          @if(Gate::allows('update', $category))
            <div class="row mt-2">
              <div class="col-12">
                <a href="{{ route('backoffice.categories.edit', $category) }}" class="btn btn-info">
                  <i class="fa fa-btn fa-save"></i> Perbarui
                </a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@extends('adminlte::page')

@section('title', 'Perbarui Kategori')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">
      Manajemen Kategori
    </h1>
  </div>
@endsection

@section('content')
  <div class="row" v-cloak>
    <div class="col-10 mx-auto">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            Perbarui Kategori
          </h3>
        </div>
        <div class="card-body">
          @include('flash::message', ['timer' => 10])

          <form method="POST" action="{{ route('backoffice.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="slug" class="col-form-label">
                    Slug
                  </label>

                  <input
                    type="text"
                    id="slug"
                    name="slug"
                    class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $category->slug) }}">

                  @error('slug')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="name" class="col-form-label">
                    Nama Kategori <span class="required">*</span>
                  </label>

                  <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}">

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-12">
                <button type="submit" class="btn btn-info">
                  <i class="fa fa-btn fa-save"></i> Perbarui
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

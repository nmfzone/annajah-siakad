@extends('adminlte::page')

@section('title', isset($article) ? 'Sunting Artikel' : 'Tambah Artikel')

@section('content_header')
  <div class="col-10 mx-auto">
    <h1 class="mb-2 text-dark">Manajemen Artikel</h1>
  </div>
@endsection

@section('content')
  <div class="row cloak-spinner" v-cloak>
    <create-or-update-article
      type="article"
      @if(isset($articleResource))
      :model='@json(Arr::only($articleResource, 'published_at'))'
      @endif
      @if(isset($article))
      :initial-categories='@json($article->categories->map(function ($c) { return $c->only('id'); }))'
      @endif
      v-slot="data">
      <div class="col-10 mx-auto">
        <div class="card card-primary">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6 my-auto">
                <h3 class="card-title">Artikel</h3>
              </div>
              <div class="col-md-6 flex justify-end">
                @if(! isset($article) || ! $article->isPublished())
                  <form-button
                    type="secondary"
                    v-if="data.isDirty"
                    :loading="data.loadingSaveDraft"
                    @click="data.saveDraft">
                    Simpan Draf
                  </form-button>
                @endif
                <form-button
                  class="ml-2"
                  type="success"
                  :disabled="!data.isDirty"
                  :loading="data.loadingUpdateOrPublish"
                  @click="data.updateOrPublishArticle">
                  {{ ! isset($article) || ! $article->isPublished() ? 'Publish' : 'Perbarui' }}
                </form-button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <alert
              state="success"
              v-if="data.submitted"
              :message="data.successMessage"
              :timer="10"
              dismissible></alert>

            <form-input
              type="hidden"
              :value="data.modelId"
              @input="data.updateProps('modelId', $event)"
              @if(isset($article))
              initial-value="{{ $article->id }}"
              @endif></form-input>

            <div class="row">
              <div class="col-12 px-md-4">
                <div class="form-group">
                  <label for="title" class="col-form-label">
                    Judul
                  </label>

                  <form-input
                    id="title"
                    type="text"
                    placeholder="Judul artikel"
                    :readonly="data.isLoading"
                    @if(isset($article))
                    initial-value="{{ $article->title }}"
                    @endif
                    :value="data.title"
                    @input="data.updateProps('title', $event)"
                    name="title"
                    required></form-input>
                </div>

                <div class="form-group">
                  <label for="content" class="col-form-label">
                    Konten
                  </label>

                  <form-input
                    id="content"
                    :wysiwyg-id="data.wysiwygId"
                    type="wysiwyg"
                    :value="data.content"
                    @input="data.updateProps('content', $event)"
                    :on-save-callback="data.onSaveCallback"
                    model-type="article"
                    @if(isset($article))
                    initial-value="{{ $article->content }}"
                    @endif
                    name="content"
                    required></form-input>
                </div>

                <div class="row">
                  <div class="col-md-6 pr-md-4">
                    <div class="form-group">
                      <label for="content" class="col-form-label">
                        Gambar Unggulan
                      </label>

                      <div class="">
                        <thumbnail-picker
                          model-type="article"
                          @selected-image="data.updateProps('thumbnailId', $event.id)"
                          @deselect-image="data.updateProps('thumbnailId', null)"></thumbnail-picker>
                      </div>
                    </div>
                  </div>
                  @if (auth()->user()->isSuperAdminOrAdmin())
                    <div class="col-md-6 pl-md-4">
                      <div class="form-group">
                        <label for="content" class="col-form-label">
                          Kategori
                        </label>

                        <div class="">
                          <category-picker
                            @if(isset($article))
                            :initial-value='@json($article->categories->map(function ($c) { return $c->only('id'); }))'
                            @endif
                            @item-checked="data.pushToProps('categories', $event)"
                            @item-unchecked="data.pullFromProps('categories', $event.id, 'id')"></category-picker>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </create-or-update-article>
  </div>
@endsection

@extends('layouts.app')

@section('content')
  <div class="container">
    {{-- title posts --}}
    <div class="justify-content-between">
      <div>
        @isset($category)
          <h4>Category: {{ $category->name }}</h4>
        @endisset

        @isset($tag)
          <h4>Tag: {{ $tag->name }}</h4>
        @endisset

        @if(!isset($tag) && !isset($category))
          <h4>All Post</h4>
        @endif
        <hr>
      </div>
    </div>
    {{-- posts --}}
    <div class="row">
      <div class="col-md-7">
        {{-- loop through post --}}
        @forelse ($posts as $post)
          {{-- single post card --}}
          <div class="card mb-4">

            {{-- thumbnail post --}}
            @if ($post->thumbnail)
              <a href="{{ route('posts.show', $post->slug) }}">  
                <img style="height: 400px; object-fit: cover; object-position: center" src="{{ $post->takeImage }}" alt="" class="card-img-top">
              </a>
            @endif

            {{-- post body --}}
            <div class="card-body">
              {{-- consist of category and tag information for each post --}}
              <div>
                <a href="{{ route('categories.show', $post->category->slug) }}" class="text-secondary">
                  <small>{{ $post->category->name }} -</small>
                </a>

                @foreach ($post->tags as $tag)
                  <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary">
                    <small>
                      {{ $tag->name }}
                    </small>
                  </a>
                @endforeach
              </div>

              {{-- post title --}}
              <h5>
                <a class="text-dark" href="{{ route('posts.show', $post->slug) }}" class="card-title">
                  {{ $post->title }}
                </a>
              </h5>

              {{-- author information --}}
              <div class="text-secondary my-3">
                {{ Str::limit($post->body, 130, '.') }}
              </div>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="media align-items-center">
                  <img width="40" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}">
                  <div class="media-body">
                    <div>
                      Wrote by {{ $post->author->name }}
                    </div>
                  </div>
                </div>
                <div class="text-secondary">
                  <small>
                    Published on {{ $post->created_at->diffForHumans() }}
                  </small>
                </div>
              </div>

            </div>
          </div>
        {{-- render alert if post is empty --}}
        @empty
          <div class="col-md-6">
            <div class="alert alert-info">
              There are no posts
            </div>
          </div>
        @endforelse

      </div>
    </div>
    {{ $posts->links() }}
  </div>
@endsection
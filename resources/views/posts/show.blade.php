@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        {{-- thumbnail post --}}
        @if ($post->thumbnail)  
          <img style="height: 550px; object-fit: cover; object-position: top" src="{{ $post->takeImage }}" alt="" class="rounded w-100">
        @endif
        {{-- post title --}}
        <h1>{{ $post->title }}</h1>

        {{-- post information --}}
        <div class="text-secondary mb-3">

          {{-- category and tag --}}
          <a href="/categories/{{ $post->category->slug }}">
            {{ $post->category->name}}
          </a>
          &middot; {{ $post->created_at->format("d F, Y") }}
          &middot;
          @foreach ($post->tags as $tag)
            <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
          @endforeach

          {{-- author information --}}
          <div class="media my-3">
            <img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}">
            <div class="media-body">
              <div>
                Wrote by {{ $post->author->name }}
              </div>
              {{ '@' . $post->author->username }}
            </div>
          </div>
          
        </div>
        <p>{!! nl2br($post->body) !!}</p>
        <div>
          @can('delete', $post)
            <div class="flex mt-3">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                Delete
              </button>
              <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
            </div>
    
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda ingin menghapus?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="mb-2"> 
                      <div>{{ $post->title }}</div>
                      <div class="text-secondary">
                        <small>Published: {{ $post->created_at->format('d F, Y') }}</small>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">

                    <form action="/posts/{{ $post->slug }}/delete" method="post">
                      @csrf
                      @method('delete')
                      <div class="d-flex">
                        <button class="btn btn-danger mr-2" type="submit">Ya</button>
                        <button class="btn btn-success" type="submit" data-dismiss="modal">Tidak</button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          @endcan
        </div>
      </div>
      
      {{-- suggested post --}}
      <div class="col-md-4">
        @foreach ($posts as $post)
          <div>
            <div class="card mb-4">
              {{-- thumbnail post --}}
              @if ($post->thumbnail)
                <a href="{{ route('posts.show', $post->slug) }}">  
                  <img style="height: 400px; object-fit: cover; object-position: center" src="{{ $post->takeImage }}" alt="" class="card-img-top">
                </a>
              @endif

              <div class="card-body">
                {{-- relevant category and tag --}}
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

                {{-- short description --}}
                <div class="text-secondary my-3">
                  {{ Str::limit($post->body, 130, '.') }}
                </div>

                {{-- author information --}}
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
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
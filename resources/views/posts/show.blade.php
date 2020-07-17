@extends('layouts.app')

@section('title', $slug)

@section('content')
  <div class="container">
    <p>{{ $slug }}</p>
  </div>
@endsection
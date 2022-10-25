@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item " aria-current="page"><a href="{{ route('post.index') }}">Post</a></li>
        <li class="breadcrumb-item active" aria-current="page">show post</li>
    </ol>
</nav>

@php
use App\Http\Controllers\PostController;
//PostController::countTotal("views","2022-10-22");
PostController::viewRecord(Auth::user()->id,$post->id,$_SERVER['HTTP_USER_AGENT']);

@endphp

<div class=" card border rounded">
   <div class="card-body">
    <h4>{{ $post->title }}</h4>
    <hr>
    <div class=" d-flex align-items-center mb-2">
        <span class=" badge small   bg-secondary">{{ \App\Models\Category::find($post->category_id)->title }}</span>
        <span class="  px-2  text-success  text-center">/</span>
        <span class=" badge   small  bg-secondary">{{ Auth::user()::find($post->user_id)->name }}</span>
        <span class="  px-2  text-success  text-center">/</span>
        <span class="badge  bg-warning mb-0 text-black-50 ">
            {{ $post->created_at->format('d M Y') }}
        </span>
        <span class="  px-2  text-success  text-center">/</span>
        <span class="badge  bg-success mb-0 text-white text-warning">
            {{ $post->created_at->format('h : m A') }}
        </span>
    </div>
    @isset($post->featured_image)
    {{--run command to connect public folder ,storage/public
    command-> php artisan storage:link
        --}}

    <img src="{{ asset("storage/".$post->featured_image) }}" alt="" class="w-100 mb-2">
    @endisset
    <div>
        @php
    echo html_entity_decode($post->description,ENT_QUOTES)
        @endphp

    </div>
    <hr>
    <div class=" d-flex justify-content-between">
        <a href="{{ route('post.create') }}" class=" btn btn-outline-primary">Create Post</a>
        <a href="{{ route('post.index') }}" class="btn btn-primary">All Post</a>
    </div>
   </div>
</div>
@endsection

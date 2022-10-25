@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">edit post</li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <h4 class="text-primary">Edit Post</h4>

        <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="">Post Title</label>
                <input type="text" value="{{ old('title',$post->title) }}"
                    class=" form-control @error('title') is-invalid
                  @enderror " name="title">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">
                <label for="">Select Category</label>
                <select type="text" class="form-select" name="category">
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $category->id == old('category',$post->category_id) ? 'selected' : ' ' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="">Post Description</label>
                <textarea class=" form-control @error('description') is-invalid
            @enderror " name="description"
                    rows="10">
            {{ old('description',$post->description) }}
            </textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <input type="file" name="featured_image">
                <button class="btn btn-lg btn-primary" type="submit">Update</button>
                @error('featured_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

        </form>
        @isset($post->featured_image)
        {{--run command to connect public folder ,storage/public
        command-> php artisan storage:link
            --}}
        <img src="{{ asset("storage/".$post->featured_image) }}" alt="" class="w-25">
        @endisset
    </div>
</div>
@endsection

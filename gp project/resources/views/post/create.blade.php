@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">create post</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="text-primary">Create Post</h4>

            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-between">
                    <input type="file" name="featured_image">
                    <button class="btn btn-lg btn-primary" type="submit">Create Post</button>
                    @error('featured_image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Post Title</label>
                    <input type="text" value="{{ old('title') }}"
                        class=" form-control @error('title') is-invalid
                      @enderror " name="title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="">Select Category</label>
                    <select type="text" class="form-select vh-25" name="category">
                        @foreach (\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : ' ' }}>
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
                    <textarea id="summernote" class=" form-control @error('description') is-invalid
                @enderror " name="description"
                        rows="10">
                {{ old('description') }}
                </textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{--summer note
                <textarea id="summernote" name="summernote"></textarea>--}}

                <div class="mb-3">
                    <label for="">Price</label>
                    <input type="text" value="{{ old('price') }}"
                        class=" form-control @error('price') is-invalid
                      @enderror " name="price">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>



            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
     $('#summernote').summernote({
        placeholder: "Description",
        tabsize:2,
        height:300
     });
  </script>
@endpush

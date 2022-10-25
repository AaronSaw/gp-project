@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mnage Post</li>
        </ol>
    </nav>
    <div class="card">

        <div class="card-body">
            <h4>Post Lists</h4>
            <hr>
            <div class=" justify-content-between mb-3">
                <div class="">
                    @if (request('keyword'))
                        <p class=" mr-1">Search By : " {{ request('keyword') }}"
                            <span><a href="{{ route('post.index') }}" class="ml-1"> @</a></span>
                        </p>
                    @endif
                </div>
            </div>
            <div class="col-11">
                <form action="{{ route('post.index') }}" method="GET" class="">
                    <form action="{{ route('post.index') }}" method="get">
                        <div class="d-flex mb-3">
                            <input type="text" class="form-control " value="{{ request('title') }}"
                                placeholder="Search post title" name="title">
                            <input type="text" class="form-control ml-2 " value="{{ request('user') }}"
                                placeholder="Search user name" name="user">
                            <input type="text" class="form-control " value="{{ request('description') }}"
                                placeholder="Search description" name="description">
                            <input type="text" class="form-control " value="{{ request('ctitle') }}"
                                placeholder="Search category" name="ctitle">
                            <input type="text" class="form-control " value="{{ request('sdate') }}"
                                placeholder="Start date" onfocus="(this.type='date')" name="sdate">
                            <input type="text" class="form-control " value="{{ request('edate') }}"
                                placeholder="End date" onfocus="(this.type='date')" name="edate">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                            <a href="{{ route('post.index') }}" class="btn btn-outline-danger" type=""> cancel</a>
                        </div>
                    </form>
                </form>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Owner</th>
                        <th>Price</th>
                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td class="">
                                {{ $post->title }}

                            </td>

                            <td>
                                {{ $post->category->title }}
                            </td>
                            <td>
                                @php
                                echo Str::words(strip_tags(html_entity_decode($post->description)), 5, '...');
                                @endphp </td>
                            {{-- <td>{{\App\Models\User::find( $post->user_id)->name }}</td> --}}
                            <td>{{ $post->name }}</td>
                            <td>${{ $post->price }}</td>
                            <td>

                                @can('update', $post)
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-dark">
                                        edit
                                    </a>
                                @endcan

                                <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-info">
                                    show
                                </a>

                                @can('delete', $post)
                                    <form action="{{ route('post.destroy', $post->id) }}" class="d-inline-block"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-outline-dark">
                                            del
                                        </button>
                                    </form>
                                @endcan

                            </td>
                            <td>
                                <p class="small mb-0 text-black-50">
                                    {{ $post->created_at->format('d M Y') }}
                                </p>
                                <p class="small mb-0 text-black-50">
                                    {{ $post->created_at->format('h : m A') }}
                                </p>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class=" text-center">There is no post</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="">
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Category</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h4>Category Lists</h4>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Owner</th>


                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                {{ $category->title }}

                            </td>

                            <td>
                                {{ Auth::user()->find($category->user_id)->name }}
                            </td>

                            <td>
                                @can('update', $category)
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-dark">
                                        edit
                                    </a>
                                @endcan

                                @can('delete', $category)
                                    <form action="{{ route('category.destroy', $category->id) }}" class="d-inline-block"
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

                                    {{ $category->created_at->format('d M Y') }}
                                </p>
                                <p class="small mb-0 text-black-50">
                                    {{ $category->created_at->format('h : m A') }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

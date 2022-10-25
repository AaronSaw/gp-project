@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mnage user</li>
        </ol>
    </nav>
    <div class="card">

        <div class="card-body">
            <h4>user Lists</h4>
            <hr>
            <div class=" d-flex justify-content-between mb-3">
               <div class="">
                @if (request('keyword'))

             <p class=" mr-1">Search By : " {{ request('keyword') }}"
                <span><a href="{{ route('user.index') }}" class="ml-1"> @</a></span></p>

             @endif
            </div>
                <form action="{{ route('user.index') }}" method="GET" class=" w-25">
                    <div class=" input-group">
                        <input type="text" class=" form-control form-control-sm" name="keyword" required>
                        <button class="btn btn-sm btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>role</th>
                        <th>Control</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class=" w-25">
                                {{ $user->name }}

                            </td>

                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->role }}
                            </td>
                            <td>

                               @can('update', $user)

                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-dark">
                                    edit
                                </a>

                                 @endcan

                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                    show
                                </a>

                                @can('delete', $user)

                                <form action="{{ route('user.destroy', $user->id) }}" class="d-inline-block"
                                    method="user">
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
                                    {{ $user->created_at->format('d M Y') }}
                                </p>
                                <p class="small mb-0 text-black-50">
                                    {{ $user->created_at->format('h : m A') }}
                                </p>
                            </td>
                        </tr>

                    @empty
                 <tr>
                    <td colspan="6" class=" text-center">There is no user</td>
                 </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="">
              {{ $users->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

@endsection


    <div class="list-group mb-3">
        <a class="list-group-item list-group-item-action" href="{{ route('home') }}">
            Home
        </a>

        <a class="list-group-item list-group-item-action" href="{{ route('test') }}">
            Test Page
        </a>

    </div>

    <p class=" text-black-50">Manage category</p>
    <div class="list-group mb-3">
        {{--<a class="list-group-item " href="{{ route('category.index')) }}">
            category list
        </a>--}}
        <a href="{{ route('category.index') }}" class=" list-group-item">category list</a>

        <a class="list-group-item list-group-item-action" href="{{ route('category.create') }}">
       create category
        </a>

    </div>

    <p class=" text-black-50">Manage Post</p>
    <div class="list-group mb-3">
        <a class="list-group-item list-group-item-action" href="{{ route('post.index') }}">
            Post list
        </a>

        <a class="list-group-item list-group-item-action" href="{{ route('post.create') }}">
       create Post
        </a>


    </div>

    <p class=" text-black-50">Manage user</p>
    <div class="list-group mb-3">
        <a class="list-group-item list-group-item-action" href="{{ route('user.index') }}">
            user list
        </a>

    </div>



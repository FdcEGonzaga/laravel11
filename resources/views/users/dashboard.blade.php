
<x-layout>
    <h1 class="title text-left">Hello, {{ auth()->user()->user_name }}!</h1>
    
    <div class="mb-4">
        @if (session('delete'))
            <x-flashMsg msg="{{ session('delete')}}" bg="bg-red-500"/>
        @elseif (session('edit'))
            <x-flashMsg msg="{{ session('edit')}}" bg="bg-blue-500"/>
        @endif
    </div>

    {{-- Create post form --}}
    <div class="card bg-white rounded shadow p-4 mb-5">
        <h2 class="font-bold text-xl mb-2">Create a post</h2>

        {{-- session msg --}}
        @if (session('success'))
            <x-flashMsg msg="{{ session('success')}}"/>
        @endif
        
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="@error('title') ring-rose-500  @enderror">

                @error('title') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- post Body --}}
            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="4" class="@error('body') ring-rose-500  @enderror">{{ old('body') }}</textarea>

                @error('body') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- post Image --}}
            <div class="mb-4">
                <label for="image">Cover photo</label>
                <input type="file" name="image" id="image"/>

                @error('image') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- button --}}
            <button class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                Create
            </button>
        </form>
    </div>

    {{-- Your latest posts --}}
    <h2 class="font-bold text-xl mb-4">You have {{ $posts->total() }} {{ $posts->total() <= 1 ? 'post' : 'posts' }}</h2>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            {{-- pass the collection/object code --}}
            <x-postCard :post="$post">
                {{-- Edit post --}}
                <a href="{{ route('posts.edit', $post) }}" class="bg-green-500 px-2 py-1 rounded-md text-sm text-white">Edit</a>

                {{-- Delete post --}}
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="bg-rose-500 px-2 py-1 rounded-md text-sm text-white ">Delete</button>
                </form>
            </x-postCard>
        @endforeach
    </div>

    {{-- pagination --}}
    <div>
        {{ $posts->links() }}
    </div>
</x-layout>
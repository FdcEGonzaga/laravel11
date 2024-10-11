<x-layout>
    {{-- back btn --}}
    <div class="mb-3">
        <a href="{{ route('dashboard') }}" class="text-blue-500 text-sm">&larr; Go back to Dashboard </a>
    </div>

    {{-- edit form --}}
    <div class="card bg-white rounded shadow p-4 mb-4">
        <h2 class="font-bold text-xl mb-2">Editing Post</h2>

        <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ $post->title }}"
                    class="@error('title') ring-rose-500  @enderror">

                @error('title') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- post Body --}}
            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="4" class=" @error('body') ring-rose-500  @enderror">{{ $post->body }}</textarea>

                @error('body') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- post Photo if exist --}}
            @if ($post->image)
                <div class="mb-4 ">
                    <label for="body">Post Photo</label>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="cover photo" class="h-64 rounded-md w-full object-cover" />
                </div>
            @endif

            {{-- upload new photo --}}
            <div class="mb-4">
                <label for="image">Post photo</label>
                <input type="file" name="image" id="image"/>

                @error('image') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- button --}}
            <button class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">
                Edit
            </button>
        </form>
    </div>
</x-layout>
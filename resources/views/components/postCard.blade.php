@props(['post', 'full' => false])

<div class="card bg-white rounded shadow p-4">
    {{-- Cover photo --}}
    <div class="mb-3">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="cover photo" class="w-full h-52 rounded"/>
        @else
            <img src="{{ asset('storage/posts_images/default_img.jpg') }}" alt="cover photo" class="w-full h-52 rounded"/>
        @endif
    </div>

    {{-- Title --}}
    <h2 class="font-bold text-xl">{{ $post->title }}</h2>

    {{-- Author and Date --}}
    <div class="text-xs font-light mb-4">
        <span>Posted {{ $post->created_at->diffForHumans() }} by <a href="{{ route('posts.user', $post->user ) }}" class="text-blue-500 font-medium">{{ $post->user->user_name }}</a></span>
    </div>

    {{-- Body --}}
    <div class="text-sm mb-2">
        @if ($full)
            <span>{{ $post->body }}</span>
        @else
            <span>{{ Str::words($post->body, 22) }}</span>
            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 ">Read more &rarr;</a>
        @endif
    </div>

    <div class="flex items-center justify-end gap-4 mt-4">
        {{ $slot }}
    </div>
</div>
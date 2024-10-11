<x-layout>
    <h1 class="title text-left">{{ $user->user_name }}'s Posts - {{ $posts->total() }}</h1>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            {{-- pass the collection/object code --}}
            <x-postCard :post="$post"/>
        @endforeach
    </div>

    {{-- pagination --}}
    <div>
        {{ $posts->links() }}
    </div>
</x-layout>
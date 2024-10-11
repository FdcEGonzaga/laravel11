<h2 class="mb-4">Hello, {{ $user->user_name }}!</h2>

<div>
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->body }}</p>

    <img width="600" src="{{ $message->embed('storage/' . $post->image) }}" alt=""/>
</div>

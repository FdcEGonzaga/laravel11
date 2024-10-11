<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public $maxFileSize = 2000;

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts =  Post::orderBy('created_at', 'desc')->get();
        // $posts =  Post::latest()->get();
        $posts = Post::latest()->paginate(6);
        
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // - validate
        $request->validate([
            'title' => ['required', 'max:100'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:'. $this->maxFileSize, 'mimes:webp,png,jpg']
        ]);

        // - store image if exist
        $path = null;
        if ($request->hasFile('image')) {
            // - public folder
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        // - eloquent creation
        // Auth::user()->posts()->create($newPost);

        // - creation manually setting
        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        // - send email after creating a post
        Mail::to(Auth::user()->email)->send(new WelcomeMail(Auth::user(), $post));

        // - redirect
        return back()->with('success', 'Your post has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // - check authorization
        Gate::authorize('modify', $post);

        // - show edit page
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // - check authorization
        Gate::authorize('modify', $post);

        // - validate
        $request->validate([
            'title' => ['required', 'max:100'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:'. $this->maxFileSize, 'mimes:webp,png,jpg']
        ]);

        // - store image if exist
        // - if no new image selected
        $path = $post->image ?? null;

        // - if new image selected
        if ($request->hasFile('image')) {
            // delete previous image
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // - save new image to public folder
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        // - update the post
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        // - redirect to dashboard
        return redirect()->route('dashboard')->with('edit', 'Your post has been edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // - check authorization
        Gate::authorize('modify', $post);

        // - delete post image if stored
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // - delete
        $post->delete();
        
        return back()->with('delete', "Your post has been deleted.");
    }
}

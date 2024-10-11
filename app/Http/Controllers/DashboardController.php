<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        // - manual getter of user's post
        // $posts = Post::where('user_id', Auth::id())->get();

        // - eloquent collection/property data getter with default order -> (remove parenthesis on posts())
        // $posts = Auth::user()->posts;

        // - to sort to latest and paginate -> (use parenthesis on post())
        $posts = Auth::user()->posts()->latest()->paginate(6);

        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(User $user) {
        $userPosts = $user->posts()->latest()->paginate(6);
        return view('users.posts', [
            'user' => $user,
            'posts' => $userPosts
        ]);
    }
}

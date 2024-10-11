<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    // - check if user owns and can modify the post
    public function modify(User $user, Post $post) : bool {
        return $user->id === $post->user_id;
    }
}

<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Een reactie mag verwijderd worden door wie ze geschreven heeft, en door
     * elke beheerder (voor moderatie).
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->is_admin || $user->id === $comment->user_id;
    }
}

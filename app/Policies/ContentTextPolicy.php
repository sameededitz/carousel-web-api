<?php

namespace App\Policies;

use App\Models\Carousel;
use App\Models\ContentText;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContentTextPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentText $contentText): Response
    {
        return $user->id === $contentText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this content text and cannot view it.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create content text for it.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentText $contentText): Response
    {
        return $user->id === $contentText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this content text and cannot update it.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentText $contentText): Response
    {
        return $user->id === $contentText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this content text and cannot delete it.');
    }
}

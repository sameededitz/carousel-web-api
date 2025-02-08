<?php

namespace App\Policies;

use App\Models\ArrowText;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArrowTextPolicy
{
    /**
     * Determine whether the user can view the arrow text.
     */
    public function view(User $user, ArrowText $arrowText): Response
    {
        return $user->id === $arrowText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot view its arrow texts.');
    }

    /**
     * Determine whether the user can create an arrow text for a carousel.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create arrow texts for it.');
    }

    /**
     * Determine whether the user can update the arrow text.
     */
    public function update(User $user, ArrowText $arrowText): Response
    {
        return $user->id === $arrowText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update its arrow texts.');
    }

    /**
     * Determine whether the user can delete the arrow text.
     */
    public function delete(User $user, ArrowText $arrowText): Response
    {
        return $user->id === $arrowText->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot delete its arrow texts.');
    }
}

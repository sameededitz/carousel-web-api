<?php

namespace App\Policies;

use App\Models\BackgroundOverlay;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BackgroundOverlayPolicy
{
    /**
     * Determine whether the user can view the background overlay.
     */
    public function view(User $user, BackgroundOverlay $backgroundOverlay): Response
    {
        return $user->id === $backgroundOverlay->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot view its background overlay.');
    }

    /**
     * Determine whether the user can create a background overlay.
     * Here we pass the Carousel instance as a second parameter.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create a background overlay for it.');
    }

    /**
     * Determine whether the user can update the background overlay.
     */
    public function update(User $user, BackgroundOverlay $backgroundOverlay): Response
    {
        return $user->id === $backgroundOverlay->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update its background overlay.');
    }

    /**
     * Determine whether the user can delete the background overlay.
     */
    public function delete(User $user, BackgroundOverlay $backgroundOverlay): Response
    {
        return $user->id === $backgroundOverlay->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot delete its background overlay.');
    }
}

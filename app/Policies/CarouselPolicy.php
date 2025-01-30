<?php

namespace App\Policies;

use App\Models\Carousel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CarouselPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function view(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to view this carousel.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update it.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to delete this carousel.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You cannot restore this carousel.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You cannot permanently delete this carousel.');
    }
}

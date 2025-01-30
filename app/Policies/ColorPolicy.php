<?php

namespace App\Policies;

use App\Models\Carousel;
use App\Models\Color;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ColorPolicy
{
    /**
     * Determine whether the user can view the color settings.
     */
    public function view(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot view its colors.');
    }

    /**
     * Determine whether the user can create a new color setting.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create colors.');
    }

    /**
     * Determine whether the user can update the color settings.
     */
    public function update(User $user, Color $color): Response
    {
        return $user->id === $color->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update its colors.');
    }

    /**
     * Determine whether the user can delete the color settings.
     */
    public function delete(User $user, Color $color): Response
    {
        return $user->id === $color->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot delete its colors.');
    }
}

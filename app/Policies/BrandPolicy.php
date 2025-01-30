<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    /**
     * Determine whether the user can view the brand settings.
     */
    public function view(User $user, Brand $brand): Response
    {
        return $user->id === $brand->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot view its brands.');
    }

    /**
     * Determine whether the user can create a new brand setting.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create brands.');
    }

    /**
     * Determine whether the user can update the brand settings.
     */
    public function update(User $user, Brand $brand): Response
    {
        return $user->id === $brand->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update its brands.');
    }

    /**
     * Determine whether the user can delete the brand settings.
     */
    public function delete(User $user, Brand $brand): Response
    {
        return $user->id === $brand->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot delete its brands.');
    }
}

<?php

namespace App\Policies;

use App\Models\Carousel;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    /**
     * Determine whether the user can view the settings.
     */
    public function view(User $user, Setting $setting): Response
    {
        return $user->id === $setting->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot view its settings.');
    }

    /**
     * Determine whether the user can create settings for the carousel.
     */
    public function create(User $user, Carousel $carousel): Response
    {
        return $user->id === $carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot create settings for it.');
    }

    /**
     * Determine whether the user can update the settings.
     */
    public function update(User $user, Setting $setting): Response
    {
        return $user->id === $setting->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot update its settings.');
    }

    /**
     * Determine whether the user can delete the settings.
     */
    public function delete(User $user, Setting $setting): Response
    {
        return $user->id === $setting->carousel->user_id
            ? Response::allow()
            : Response::deny('You do not own this carousel and cannot delete its settings.');
    }
}

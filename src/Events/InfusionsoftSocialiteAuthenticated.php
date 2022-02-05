<?php

namespace InfusionsoftSocialite\Events;

use Laravel\Socialite\Two\User;
use Illuminate\Foundation\Events\Dispatchable;

class InfusionsoftSocialiteAuthenticated
{
    use Dispatchable;

    /**
     * Authenticated user
     *
     * @var User
     */
    public $user;

    /**
     * Undocumented function
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

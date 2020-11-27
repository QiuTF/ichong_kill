<?php

namespace App\Policies;

use App\Models\Player;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(Player $currentUser, Player $user)
    {
        return $currentUser->id === $user->id;
    }
}

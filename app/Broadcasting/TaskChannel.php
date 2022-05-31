<?php

namespace App\Broadcasting;

use App\Entity\User;

class TaskChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Entity\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        //
    }
}

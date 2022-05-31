<?php

namespace App\Broadcasting;

use App\Entity\User;

class Task
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
     * @param  \App\Entity\Task  $task
     * @return array|bool
     */
    public function join(User $user, Task $task)
    {
        return true;//$user->id === $t->user_id;
    }
}

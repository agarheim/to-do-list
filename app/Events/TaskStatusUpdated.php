<?php

namespace App\Events;

use App\Entity\Task;
use App\Entity\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStatusUpdated implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $afterCommit = true;
    /**
     * @var Task
     */
    public $task;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->broadcastToEveryone();

    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('trades');
//        return new PrivateChannel('tasks');
    }
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['id'         => $this->task->id,
                'name_task'  => $this->task->name_task,
                'status'     => $this->task->status,
            ];
    }
}

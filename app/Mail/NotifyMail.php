<?php

namespace App\Mail;

use App\Entity\Task;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;
    /**
     * @var Task
     */
    public $task;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Task $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Status Task '.$this->task->id.', was changed')
            ->markdown('emails.tasks.taskUpdate');
    }
}

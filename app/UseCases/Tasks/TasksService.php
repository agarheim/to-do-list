<?php

namespace App\UseCases\Tasks;

use App\Entity\Task;
use App\Entity\User;
use App\Events\TaskStatusUpdatedOk;
use App\Mail\NotifyMail;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

class TasksService
{
    private $mailer;
    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function updateStatus(Request $request): Task
    {
        $id = $request->post('id');
        $status = $request->post('status');
        $task = Task::find($id);
        try {
            $status =  $this->isTransferStatus($task->status,$status);
        }catch (\Exception $e){
            throw new \InvalidArgumentException($e->getMessage());
        }
        $task->update(['status' => $status]);

        $this->mailer->to(env('MAIL_FROM_ADDRESS'))->send(new NotifyMail(auth()->user(),$task));
        $this->dispatcher->dispatch(new TaskStatusUpdatedOk($task));
        return $task;
    }

    public function isTransferStatus($oldStatus,$newStatus)
    {
        if ($oldStatus == $newStatus){
            throw new \Exception('This status setted'.$oldStatus);
        }
        if ($oldStatus == Task::STATUS_NEW && $newStatus == Task::STATUS_TO_WORK ||
            $oldStatus == Task::STATUS_TO_WORK && $newStatus == Task::STATUS_FNISHED ||
            $oldStatus == Task::STATUS_FNISHED && $newStatus == Task::STATUS_ARCHIVE){
            return $newStatus;
        }else{
            throw new \Exception('So It is not work. Status transfer:'.Task::STATUS_NEW.'->'.
                Task::STATUS_TO_WORK.'->'.Task::STATUS_FNISHED.'->'.Task::STATUS_ARCHIVE);
        }
    }
}

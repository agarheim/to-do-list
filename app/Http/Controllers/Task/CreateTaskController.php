<?php

namespace App\Http\Controllers\Task;

use App\Entity\Task;
use App\Events\TaskStatusUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Composer\Autoload\includeFile;

class CreateTaskController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if($request->isXmlHttpRequest() ){
            $name = $request->post('descriptionTask');
            $task = new Task();
            $task->name_task = $request->post('descriptionTask');
            $task->status = Task::STATUS_NEW;
            $task->save();

            TaskStatusUpdated::broadcast($task);
//         var_dump($request->post('descriptionTask'));
//
        }

        return response()->json([
            'name' => $name,
            'state' => 'CA',
             ]);


    }


}

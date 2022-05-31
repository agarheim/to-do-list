<?php

namespace App\Http\Controllers\Task;

use App\Entity\Task;
use App\Events\TaskStatusUpdatedOk;
use App\Http\Controllers\Controller;
use App\UseCases\Tasks\TasksService;
use Illuminate\Http\Request;



class UpdateStatusTaskController extends Controller
{
    /**
     * @var TasksService
     */
    private $service;

    public function __construct(TasksService $service)
    {
//        $this->middleware('guest');
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$request->isXmlHttpRequest() ){
            return response()->json(['error' => 'not valid request type'],422);
        }
        try {
            $task = $this->service->updateStatus($request);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],422);
        }
        return response()->json([
            'id' => $task->id,
            'status' => $task->status
             ]);
    }


}

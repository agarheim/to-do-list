<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Task $task)
    {
        $taskItems = $task::whereIn('status',[Task::STATUS_NEW,Task::STATUS_TO_WORK,Task::STATUS_FNISHED])->get();
        return view('home',[
            'taskItems'=>$taskItems,
        ]);
    }
}

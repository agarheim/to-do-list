<?php

use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\UpdateStatusTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Auth::routes();
Route::post('/task/add', [CreateTaskController::class,'index'])->name('task/add');
Route::post('/task/update', [UpdateStatusTaskController::class,'index'])->name('task/update');

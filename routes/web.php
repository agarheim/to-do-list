<?php

use App\Http\Controllers\Task\CreateTaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\UpdateStatusTaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/task/add', [CreateTaskController::class,'index'])->name('task/add');
Route::post('/task/update', [UpdateStatusTaskController::class,'index'])->name('task/update');

<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectsTasksController;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'auth'],function(){
    Route::get('/projects', [ProjectsController::class, 'index']);  //dashboard
    Route::get('/projects/create', [ProjectsController::class, 'create']);  
    Route::get('/projects/{project}', [ProjectsController::class, 'show']);
    Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit']);
    Route::patch('/projects/{project}', [ProjectsController::class, 'update']);
    Route::post('/projects', [ProjectsController::class, 'store']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('/projects/{project}/tasks', 'ProjectsTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectsTasksController@update');

});


Route::resource('home', HomeController::class);


Auth::routes();


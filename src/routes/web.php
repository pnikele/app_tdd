<?php

use App\Http\Controllers\ProjectsController;
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
    Route::post('/projects', [ProjectsController::class, 'store']);
    //Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Route::resource('home', HomeController::class);


Auth::routes();


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

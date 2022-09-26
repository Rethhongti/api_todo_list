<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('/todo', TaskController::class);

Route::get('/allTodo',[TaskController::class, 'index']);
Route::post('/addTodo',[TaskController::class, 'store']);
Route::post('/updateTodo',[TaskController::class, 'update']);
Route::post('/changeTaskStatus',[TaskController::class, 'markAsComplete']);
Route::get('/searchTodo/{keyword?}',[TaskController::class, 'show']);
Route::delete('/deleteTodo/{id}',[TaskController::class, 'destroy']);

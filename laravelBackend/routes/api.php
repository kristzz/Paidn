<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegularUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Open routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
// Protected routes
Route::group([
    "middleware" => "auth:api"
], function (){
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/deleteUser', [UserController::class, 'deleteUser']);

    Route::post('/post', [PostController::class, 'post']);
    Route::get('/getPosts', [PostController::class, 'getPosts']);
    Route::get('/deletePost', [PostController::class, 'deletePost']);

    Route::post('/insertUserData', [RegularUserController::class, 'insertUserData']);
    Route::get('/getUserProfile', [RegularUserController::class, 'getUserProfile']);
});

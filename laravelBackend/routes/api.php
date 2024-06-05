<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegularUserController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\WorkController;
use App\Http\Controllers\Api\ApplyController;
use App\Http\Controllers\Api\PhotoController;

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
    Route::post('/editPosts', [PostController::class, 'editPosts']);
    Route::get('/getPosts', [PostController::class, 'getPosts']);
    Route::get('/getMyPosts', [PostController::class, 'getMyPosts']);
    Route::delete('/deletePost', [PostController::class, 'deletePost']);

    Route::get('/admin/users', [UserController::class, 'getUsers']);
Route::delete('/admin/users/{id}', [UserController::class, 'deleteUserAdmin']);
Route::get('/admin/posts', [PostController::class, 'getPostsAdmin']);
Route::delete('/admin/posts/{id}', [PostController::class, 'deletePostAdmin']);

    Route::post('/saveBusiness', [BusinessController::class, 'saveBusinessProfile']);
    Route::get('/getBusinessProfile', [BusinessController::class, 'getBusinessProfile']);

    Route::post('/editRegularUser', [RegularUserController::class, 'editRegularUser']);
    Route::get('/getUserProfile', [RegularUserController::class, 'getUserProfile']);

    Route::post('/addEducation', [EducationController::class, 'addEducation']);
    Route::post('/editEducation', [EducationController::class, 'editEducationExperience']);
    Route::get('/getEducation', [EducationController::class, 'getEducation']);
    Route::get('/deleteEducation', [EducationController::class, 'deleteEducation']);

    Route::post('/addWork', [WorkController::class, 'addWorkExperience']);
    Route::post('/editWork', [WorkController::class, 'editWorkExperience']);
    Route::get('/getWork', [WorkController::class, 'getWorkExperience']);
    Route::get('/deleteWork', [WorkController::class, 'deleteWorkExperience']);

    Route::post('/applyForJob', [ApplyController::class, 'applyForJob']);
    Route::get('/getApplications', [ApplyController::class, 'getApplications']);

    Route::post('/uploadPhoto', [PhotoController::class, 'uploadPhoto']);
    Route::post('/removePhoto', [PhotoController::class, 'removePhoto']);
    Route::post('/editPhoto/{id}', [PhotoController::class, 'editPhoto']);
    Route::get('/photo/{id}', [PhotoController::class,'/getPhoto']);
});

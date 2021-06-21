<?php

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

Route::get('/test',function (Request $request){
    return response()->json('hello world',200);
});


Route::group([
    'prefix' => 'v1/auth',
    'namespace' => 'Auth',
], function () {
    Route::post('login', [\App\Http\Controllers\API\v1\Auth\AuthController::class, 'login']);
    Route::post('login/provider', [\App\Http\Controllers\API\v1\Auth\AuthController::class, 'loginWithProvider']);
    Route::post('signup', [\App\Http\Controllers\API\v1\Auth\AuthController::class, 'signup']);
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::resource('/exams', \App\Http\Controllers\API\v1\ExamController::class)->except(['index','edit','create', 'destroy']);
    Route::resource('/users', \App\Http\Controllers\API\v1\UserController::class)->except(['create', 'edit']);
    Route::resource('/questions', \App\Http\Controllers\API\v1\QuestionController::class)->except(['create', 'edit']);
    Route::resource('/categories', \App\Http\Controllers\API\v1\QuestionCategoryController::class)->except(['create', 'edit']);
    Route::resource('/answers', \App\Http\Controllers\API\v1\RoleController::class)->except(['index', 'create','show', 'edit']);
    Route::resource('/roles',\App\Http\Controllers\API\v1\RoleController::class);

});


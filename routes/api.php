<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MemberController;
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

Route::post('/login',[ApiController::class,'login'] );
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [RegisterController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/users',[ApiController::class,'getUsers'] )->middleware('auth:sanctum');
Route::apiResource('genres', GenreController::class)->middleware('auth:sanctum');
Route::apiResource('books', BookController::class)->middleware('auth:sanctum');
Route::apiResource('members', MemberController::class)->middleware('auth:sanctum');



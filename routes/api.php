<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\ReservationsController;
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
//books
Route::middleware('auth:sanctum')->group(function () {
    Route::get('books', [BookController::class, 'index']);
    Route::post('books', [BookController::class, 'store']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
});//member
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('members', MemberController::class);
    Route::put('/loans/{id}/return', [LoansController::class, 'returnBook']); // Return a Book
Route::resource('loans', LoansController::class);
Route::resource('reservations', ReservationsController::class);
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller\Authentication;
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
Route::group([
    'prefix' => 'Auth'
], function () {
    Route::post('login', [App\Http\Controllers\Authcontroller\Authentication::class, 'login'])->name('login');
    Route::post('register', [App\Http\Controllers\Authcontroller\Authentication::class, 'register'])->name('register');
    Route::post('logout', [App\Http\Controllers\Authcontroller\Authentication::class, 'logout'])->middleware('auth:sanctum');
    Route::post('delete', [App\Http\Controllers\Authcontroller\Authentication::class, 'delete'])->middleware('auth:sanctum');
});
Route::post('logadmin', [App\Http\Controllers\Authcontroller\Authentication::class, 'logadmin'])->middleware('AdminLogin');
route::post('image', [App\Http\Controllers\PhotoController::class, 'image']);
route::get('show/{id}', [App\Http\Controllers\PhotoController::class, 'show']);
route::get('test', [App\Http\Controllers\PhotoController::class, 'test']);

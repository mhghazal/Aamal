<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller\Authentication;
use App\Http\Controllers\Authcontroller\AuthenticationAdmin;
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

                         //////////////PassWord//////////
    Route::post('forgot-password',[App\Http\Controllers\Authcontroller\Authentication::class,'ForgotPassword']);
    Route::post('check-password',[App\Http\Controllers\Authcontroller\Authentication::class,'CodeCheck']);
    Route::post('reset',[App\Http\Controllers\Authcontroller\Authentication::class,'Reset']);
});

Route::group([
    'prefix' => 'Auth_admin'
], function () {
    Route::post('register', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'register'])->name('register');
    Route::post('login', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'login'])->name('login');
    Route::post('logout', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'logout'])->middleware('auth:sanctum');
    Route::post('delete', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'delete'])->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('profile', App\Http\Controllers\ProfileController::class);
    Route::post('update_photo_profile/{profile}', [App\Http\Controllers\ProfileController::class, 'update_photo_profile']);
});
Route::middleware('AdminLogin:sanctum')->group(function () {
    Route::resource('section', App\Http\Controllers\SectionController::class);
    Route::post('update_photo_section/{section}', [App\Http\Controllers\SectionController::class, 'update_photo_section']);
});
Route::middleware('AdminLogin:sanctum')->group(function () {
    Route::resource('course', App\Http\Controllers\CourseController::class);
    Route::Post('store_course/{value}', [App\Http\Controllers\CourseController::class, 'store_course']);
    Route::post('update_photo_course/{course}', [App\Http\Controllers\CourseController::class, 'update_photo_course']);
});
Route::middleware('AdminLogin:sanctum')->group(function () {
    Route::resource('game', App\Http\Controllers\GameController::class);
    Route::post('store_game/{value}', [App\Http\Controllers\GameController::class, 'store_game']);
    Route::post('update_photo_game/{game}', [App\Http\Controllers\GameController::class, 'update_photo_game']);
});
Route::middleware('AdminLogin:sanctum')->group(function () {
    Route::resource('n_course', App\Http\Controllers\NCourseController::class);
    Route::Post('store_n_course/{value}', [App\Http\Controllers\NCourseController::class, 'store_n_course']);
    Route::post('update_photo_voice_n_Course/{n_course}', [App\Http\Controllers\NCourseController::class, 'update_photo_voice_n_Course']);
});
Route::middleware('AdminLogin:sanctum')->group(function () {
    Route::resource('n_game', App\Http\Controllers\NGameController::class);
    Route::Post('store_n_game/{value}', [App\Http\Controllers\NGameController::class, 'store_n_game']);
    Route::post('update_photo_voice_n_Game/{n_course}', [App\Http\Controllers\NGameController::class, 'update_photo_voice_n_Game']);
});

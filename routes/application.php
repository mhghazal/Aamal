<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'Auth',], function () {

    Route::post('login', [App\Http\Controllers\Application\Authcontroller::class,'login']);
    Route::post('register', [App\Http\Controllers\Application\Authcontroller::class,'register']);
    Route::post('logout', [App\Http\Controllers\Application\Authcontroller::class,'logout']);
    Route::post('delete', [App\Http\Controllers\Application\Authcontroller::class,'delete']);

              //////////////PassWord//////////
    Route::post('forgot-password', [App\Http\Controllers\Application\Authcontroller::class,'ForgotPassword']);
    Route::post('check-password', [App\Http\Controllers\Application\Authcontroller::class,'CodeCheck']);
    Route::post('reset', [App\Http\Controllers\Application\Authcontroller::class,'Reset']);

    Route::get('userinfo', [App\Http\Controllers\Application\Authcontroller::class,'userinfo']);

});

    Route::get('sections',[App\Http\Controllers\Application\MainController::class,'Sections']);
    Route::get('courses',[App\Http\Controllers\Application\MainController::class,'Courses']);
    Route::get('games',[App\Http\Controllers\Application\MainController::class,'Games']);
    Route::get('profile',[App\Http\Controllers\Application\MainController::class,'Profile']);

    route::get('SectionBody/{name}',[App\Http\Controllers\Application\MainController::class,'SectionBody']);
    route::post('feedback',[App\Http\Controllers\Application\MainController::class,'feedback']);

    route::get('chooseCourse/{id}',[App\Http\Controllers\Application\MainController::class,'ChooseCourse']);
    route::get('chooseGame/{id}',[App\Http\Controllers\Application\MainController::class,'ChooseGame']);

    route::post('ResponseGame',[App\Http\Controllers\Application\MainController::class,'ResponseGame']);
    route::post('ResponseCourse',[App\Http\Controllers\Application\MainController::class,'ResponseCourse']);






    Route::get('/test',function(){
        return "online";
    });


   





// Route::get('/imge',[App\Http\Controllers\CourseController::class,'index']);
Route::get('/tt',[App\Http\Controllers\ImageUploadController::class,'mcd']);

// Application/ProfileResources

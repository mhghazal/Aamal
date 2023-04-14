<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Authcontroller\Basecontroller as Basecontroller;
use App\Models\Photo;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Basecontroller
{
    public function image(Request $request)
    {
    }
    public function show($id)
    {
        $photo = Photo::findOrFail($id);

        return response($photo->photo)->header('Content-Type', 'image/jpeg');
    }

    public function store(Request $request)
    {
        $photo = new Photo;
        $photo->name = $request->name;
        $photo->photo = $request->file('photo')->get();
        // $photo->photo = $photoData;
        $photo->save();
    }

    public function test()
    {
        $array = [
            ['user' => ['id' => 1, 'name' => 'User 1', 'email' => 'user1@example.com']],
            ['user' => ['id' => 2, 'name' => 'User 2', 'email' => 'user2@example.com']],
        ];

        $emails = [];

        return Arr::pluck($array, 'user');
        //  $emails;
    }

    public  function tt(AuthManager $auth)
    {
        $user = $auth->user();
        $user = Auth::user();
    }
}

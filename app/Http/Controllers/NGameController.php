<?php

namespace App\Http\Controllers;

use App\Models\User\N_Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Game;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use App\Http\Resources\N_Game as NGameResourse;
use App\Http\Resources\N_Game as ResourcesN_Game;
use Symfony\Component\Mime\FileBinaryMimeTypeGuesser;

class NGameController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $n_Game = N_Game::all();
            return $this->sendresponse(ResourcesN_Game::collection($n_Game), 'all n_Game');
        } catch (\Exception $e) {
            return $this->senderror($e, 'the n_Game not found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_n_game(Request $request, $value)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_image' => 'required',
                'n_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048',
                'voice' => 'required|mimes:mp3,mp4,avi,flv,webm,m4a,3gp,wav',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            if ($request->has('n_image') && $request->has('voice')) {
                $n_Game = new N_Game();
                $game = Game::find($value);
                $file = $request->file('n_image');
                $file_voice = $request->file('voice');
                $filedata = file_get_contents($request->n_image);
                $filedata_voice = file_get_contents($request->voice);
                $mimetype = $file->getMimeType();
                $mimetype_voice = $file_voice->getMimeType();
                $n_Game->game_id =  $game->id;
                $n_Game->name_image = $request->name_image;
                $n_Game->photo_type = $mimetype;
                $n_Game->voice_type = $mimetype_voice;
                $n_Game->n_image = $filedata;
                $n_Game->voice = $filedata_voice;
                $n_Game->save();
                return $this->sendresponse(['message' => 'N_Game Add successfly'], 200);
            } else {
                return $this->senderror('please validate error-->N_Game not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->N_Game not Storing');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\N_Game  $n_Game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $game = N_Game::find($id);
            if (is_null($game)) {
                return $this->senderror('Error', ['message'=>'the N_Game not found'], 404);
            } else {
                return $this->sendresponse(new ResourcesN_Game($game), 'one N_Game');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'the N_Game not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\N_Game  $n_Game
     * @return \Illuminate\Http\Response
     */
    public function edit(N_Game $n_Game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\N_Game  $n_Game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_image' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            $n_Game = N_Game::findOrFail($id);
            $n_Game->name_image = $request->name_image;
            $n_Game->save();
            return $this->sendresponse(['message' => 'N_Game update name successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->N_Game not Storing');
        }
    }

    public function update_photo_voice_n_Game(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'n_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048',
                'voice' => 'required|mimes:mp3,mp4,avi,flv,webm,m4a,3gp,wav',
            ]);
            if ($request->has('n_image') && $request->has('voice')) {
                $file = $request->file('n_image');
                $file_voice = $request->file('voice');
                $filedata = file_get_contents($request->n_image);
                $filedata_voice = file_get_contents($request->voice);
                $mimetype = $file->getMimeType();
                $mimetype_voice = $file_voice->getMimeType();
                $n_Game = N_Game::findOrFail($id);
                $n_Game->photo_type = $mimetype;
                $n_Game->voice_type = $mimetype_voice;
                $n_Game->n_image = $filedata;
                $n_Game->voice = $filedata_voice;
                $n_Game->save();
                return $this->sendresponse(['message' => 'N_Game update photo and voice successfly'], 200);
            } else {
                return $this->senderror('please validate error-->N_Game photo and voice not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->N_Game photo and voice not Storing');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\N_Game  $n_Game
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $n_Game = N_Game::findOrFail($id);
            $n_Game->delete();
            return $this->sendresponse(['message' => 'N_Game delete successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'N_Game delete error');
        }
    }
}

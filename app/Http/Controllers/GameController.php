<?php

namespace App\Http\Controllers;

use App\Models\User\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Section;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use App\Http\Resources\Game as GameResourse;

class GameController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $course = Game::all();
            return $this->sendresponse(GameResourse::collection($course), 'all Games');
        } catch (\Exception $e) {
            return $this->senderror($e, 'the Games not found');
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
    public function store_game(Request $request, $value)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_game' => 'required',
                'game_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }

            if ($request->has('game_image')) {
                $game = new Game;
                $section = Section::find($value);
                $file = $request->file('game_image');
                $filedata = file_get_contents($request->game_image);
                $mimetype = $file->getMimeType();
                $game->section_id =  $section->id;
                $game->name_game = $request->name_game;
                $game->slug = $request->slug;
                $game->photo_type = $mimetype;
                $game->game_image = $filedata;
                $game->save();
                return $this->sendresponse(['message' => 'Game Add successfly'], 200);
            } else {
                return $this->senderror('please validate error-->Game not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Game not Storing');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $game = Game::find($id);
            if (is_null($game)) {
                return $this->senderror('Error', ['message' => 'the Game not found'], 404);
            } else {
                return $this->sendresponse(new GameResourse($game), 'one Game');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'the Game not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_game' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            $game->name_game = $request->name_game;
            $game->save();
            return $this->sendresponse(['message' => 'Game update name successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Game not Storing');
        }
    }

    public function update_photo_game(Request $request, Game $game)
    {
        try {

            $validator = Validator::make($request->all(), [
                'game_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
            ]);
            if ($request->has('game_image')) {
                $file = $request->file('game_image');
                $filedata = file_get_contents($request->game_image);
                $mimetype = $file->getMimeType();
                $game->photo_type = $mimetype;
                $game->game_image = $filedata;
                $game->save();
                return $this->sendresponse($game->name_game, 'Game update photo successfly');
            } else {
                return $this->senderror('please validate error-->Game photo not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Game photo not Storing');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        try {
            $game->n__games()->get(['id'])->each->delete();
            $game->delete();
            return $this->sendresponse(['message' => 'Game delete successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please delete error');
        }
    }
}

<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Authcontroller\Basecontroller;
use App\Http\Resources\Application\ProfileResources;
use App\Http\Resources\Course as CourseResourse;
use App\Http\Resources\Game as GameResourse;
use App\Http\Resources\N_Course as ResourcesN_Course;
use App\Http\Resources\N_Game as ResourcesN_Game;
use App\Models\FeedBack;
use App\Models\User;
use App\Models\User\Course;
use App\Models\User\Game;
use App\Models\User\N_Course;
use App\Models\User\N_Game;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class MainController extends Basecontroller
{

    use HasApiTokens;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function Sections(SectionService $section)
    {
        return $section->getAllSections();
    }

    public function Courses()
    {
        try {
            $Courses = Course::all();
            return $this->sendresponse(
                CourseResourse::collection($Courses), 'All Courses'
            );
        } catch (\Exception $e) {
            return $this->senderror($e, 'The Courses Not found');
        }
    }

    public function Games()
    {
        try {
            $Games = Game::all();
            return $this->sendresponse(
                GameResourse::collection($Games), 'All Games'
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function Profile()
    {
        try {
            $Profile = User::find(auth::id());
            return $this->sendresponse(
                new ProfileResources($Profile), 'none'
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function SectionBody($name, SectionService $body)
    {
        return $body->SectionBody($name);
    }

    public function feedback(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ], [
            'message.required' => 'The message field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $feedback = new FeedBack();
        $feedback->message = $request->message;
        $feedback->user_id = auth()->user()->id;
        $feedback->save();

        return response()->json([
            'success' => true,
            'message' => 'Data has been successfully saved.',
        ]);
    }

    public function ChooseCourse($id)
    {
        $courses = N_Course::where('id', $id)->get();
          if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'Course not found',
            ]);
        }
        return response()->json([
            'courses' => ResourcesN_Course::collection($courses),
        ]);

    }

    public function ChooseGame($id)
    {
        $game = N_Game::find($id);
        return response()->json([
            'game' => ResourcesN_Game::collection($game),
        ]);
    }

    public function ResponseGame(Request $request)
    {

    }

    public function ResponseCourse(Request $request)
    {

    }

}

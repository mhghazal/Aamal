<?php

namespace App\Http\Controllers;

use App\Models\User\N_Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Course;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use App\Http\Resources\N_Course as NCourseResourse;
use App\Http\Resources\N_Course as ResourcesN_Course;
use Symfony\Component\Mime\FileBinaryMimeTypeGuesser;

class NCourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $n_course = N_Course::all();
            return $this->sendresponse(ResourcesN_Course::collection($n_course), 'all n_courses');
        } catch (\Exception $e) {
            return $this->senderror($e, 'the n_course not found');
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
    public function store_n_course(Request $request, $value)
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
                $n_course = new N_Course;
                $course = Course::find($value);
                $file = $request->file('n_image');
                $file_voice = $request->file('voice');
                $filedata = file_get_contents($request->n_image);
                $filedata_voice = file_get_contents($request->voice);
                $mimetype = $file->getMimeType();
                $mimetype_voice = $file_voice->getMimeType();
                $n_course->course_id =  $course->id;
                $n_course->name_image = $request->name_image;
                $n_course->photo_type = $mimetype;
                $n_course->voice_type = $mimetype_voice;
                $n_course->n_image = $filedata;
                $n_course->voice = $filedata_voice;
                $n_course->save();
                return $this->sendresponse(['message' => 'N_Course Add successfly'], 200);
            } else {
                return $this->senderror('please validate error-->N_Course not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->N_Course not Storing', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\N_Course  $n_Course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course = N_Course::find($id);
            if (is_null($course)) {
                return $this->senderror('Error', ['message' => 'the N_Course not found'], 404);
            } else {
                return $this->sendresponse(new ResourcesN_Course($course), 'one N_Course');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'the N_Course not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\N_Course  $n_Course
     * @return \Illuminate\Http\Response
     */
    public function edit(N_Course $n_Course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\N_Course  $n_Course
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
            $n_Course = N_Course::findOrFail($id);
            $n_Course->name_image = $request->name_image;
            $n_Course->save();
            return $this->sendresponse(['message' => 'n_Course update name successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->n_Course not Storing');
        }
    }

    public function update_photo_voice_n_Course(Request $request, $id)
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
                $n_Course = N_Course::findOrFail($id);
                $n_Course->photo_type = $mimetype;
                $n_Course->voice_type = $mimetype_voice;
                $n_Course->n_image = $filedata;
                $n_Course->voice = $filedata_voice;
                $n_Course->save();
                return $this->sendresponse(['message' => 'N_Course update photo and voice successfly'], 200);
            } else {
                return $this->senderror('please validate error-->N_Course photo and voice not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->N_Course photo and voice not Storing');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\N_Course  $n_Course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $n_Course = N_Course::findOrFail($id);
            $n_Course->delete();
            return $this->sendresponse(['message' => 'N_Course delete successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'N_Course delete error');
        }
    }
}

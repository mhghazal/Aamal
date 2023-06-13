<?php

namespace App\Http\Controllers;

use App\Models\User\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Section;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use App\Http\Resources\Course as CourseResourse;
use App\Models\User\N_Course;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $course = Course::all();
            return $this->sendresponse(CourseResourse::collection($course), 'all courses');
        } catch (\Exception $e) {
            return $this->senderror($e, 'the course not found');
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
    public function store_course(Request $request, $value)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_course' => 'required',
                'course_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            if ($request->has('course_image')) {
                $course = new Course;
                $section = Section::find($value);
                $file = $request->file('course_image');
                $filedata = file_get_contents($request->course_image);
                $mimetype = $file->getMimeType();
                $course->section_id =  $section->id;
                $course->name_course = $request->name_course;
                $course->slug = $request->slug;
                $course->photo_type = $mimetype;
                $course->course_image = $filedata;
                $course->save();
                return $this->sendresponse(['message' => 'Course Add successfly'], 200);
            } else {
                return $this->senderror('please validate error-->Course not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Course not Storing', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course = Course::find($id);
            if (is_null($course)) {
                return $this->senderror('Error', ['message' => 'the Course not found'], 404);
            } else {
                return $this->sendresponse(new CourseResourse($course), 'one course');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'the course not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_course' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            $course->name_course = $request->name_course;
            $course->save();
            return $this->sendresponse(['message' => 'course update name successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->course not Storing');
        }
    }

    public function update_photo_course(Request $request, Course $course)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
            ]);
            if ($request->has('course_image')) {
                $file = $request->file('course_image');
                $filedata = file_get_contents($request->course_image);
                $mimetype = $file->getMimeType();
                $course->photo_type = $mimetype;
                $course->course_image = $filedata;
                $course->save();
                return $this->sendresponse($course->name_course, 'Course update photo successfly');
            } else {
                return $this->senderror('please validate error-->Course photo not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Course photo not Storing');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        try {
            $course->n_course()->get(['id'])->each->delete();
            $course->delete();
            return $this->sendresponse(['message' => 'course delete successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please delete error');
        }
    }
}

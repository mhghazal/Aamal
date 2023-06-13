<?php
namespace App\Services;

use App\Http\Controllers\Authcontroller\Basecontroller;
use App\Models\User\Section;
use App\Http\Resources\Section as SectionResourse;
use App\Models\User\Course;
use App\Models\User\Game;
use App\Http\Resources\Game as GameResourse;
use App\Http\Resources\Course as CourseResourse;

class SectionService extends Basecontroller
{

    public function getAllSections()
    {
        try {
            $sections = Section::all();
            $length = $sections->count();

            return response()->json([
                'Count of Sections' => $length,
                'Sections' => SectionResourse::collection($sections),
                'message' => 'All Sections',
            ]);
        } catch (\Exception $e) {
            return $this->senderror($e, 'The Sections Not Found');
        }
    }

    public function SectionBody($name)
    {
        $section = Section::where('name_section', $name)->first();

        if (!$section) {
            return response()->json([
                'message' => "Section not found with name '{$name}'.",
            ], 404);
        }

        $games = $section->games;
        $courses = $section->courses;

        $response = [
            'Section Name' => $name,
            'Games' => [
                'Count' => $games->count(),
                'List' => GameResourse::collection($games),
            ],
            'Courses' => [
                'Count' => $courses->count(),
                'List' => CourseResourse::collection($courses),
            ],
        ];

        return response()->json($response);
    }
}

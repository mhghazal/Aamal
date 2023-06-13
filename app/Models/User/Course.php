<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'name_course',
        'slug',
        'course_image',
        'section_id'
    ];
    public function section()
    {
        return $this->belongsToMany(Section::class);
    }
    public function n_course()
    {
        return $this->hasOne(N_Course::class);
    }
}

<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class N_Course extends Model
{
    use HasFactory;
    protected $table = 'n__courses';
    protected $fillable = [
        'name_image',
        'course_id',
        'n_image',
        'voice'
    ];
    public function course()
    {
        return $this->belongsToMany(Course::class);
    }
}

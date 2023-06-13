<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = [
        'name_section',
        'slug',
        'section_image'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

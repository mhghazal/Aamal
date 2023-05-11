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
        'section_image'
    ];
    public function course()
    {
        return $this->hasOne(course::class);
    }
    public function game()
    {
        return $this->hasOne(Game::class);
    }
}

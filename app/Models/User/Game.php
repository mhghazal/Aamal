<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $table = 'games';
    protected $fillable = [
        'name_game',
        'slug',
        'game_image',
        'section_id'
    ];
    public function section()
    {
        return $this->belongsToMany(Section::class);
    }
    public function n__games()
    {
        return $this->hasOne(N_Game::class);
    }
}

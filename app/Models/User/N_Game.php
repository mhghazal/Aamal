<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class N_Game extends Model
{
    use HasFactory;
    protected $table = 'n__games';
    protected $fillable = [
        'name_image',
        'game_id',
        'n_image',
        'voice'
    ];
    public function game()
    {
        return $this->belongsToMany(Game::class);
    }
}

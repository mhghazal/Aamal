<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Game extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'game_name' => $this->name_game,
            'slug' =>$this->slug,
            'photo_type'  => $this->photo_type,
            'game_image' => $getfile = "data:" . $this->photo_type . ";base64," . base64_encode($this->game_image),
            // 'created_at' => $this->created_at->format('D/M/Y'),
            // 'updated_at' => $this->updated_at->format('D/M/Y'),
        ];
    }
}

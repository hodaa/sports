<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function GuzzleHttp\uri_template;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->title,
            'image' => $this->image ? url($this->image) : null,
            'video' => $this->video,
            'week'=> $this->week->title
        ];
    }
}

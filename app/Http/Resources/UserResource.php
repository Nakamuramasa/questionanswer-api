<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'photo_url' => $this->photo_url,
            $this->mergeWhen(auth()->check() && auth()->id() == $this->id, [
                'email' => $this->email,
            ]),
            'questions' => QuestionResource::collection(
                $this->whenLoaded('questions')
            ),
            'create_date' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}

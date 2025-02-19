<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'author_id' => $this->author_id,
            'news_content' => $this->news_content,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'writer' => $this->whenLoaded('Writer'),
            'comment' => $this->whenLoaded('Comment', function () {
                return collect($this->Comment)->each(function ($comment) {
                    $comment->Commentator;
                    return $comment;
                });
            }),
            'total_comment' => $this->whenLoaded('Comment', function () {
                return $this->Comment->count();
            })
        ];
    }
}

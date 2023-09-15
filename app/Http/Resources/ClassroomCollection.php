<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassroomCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($model) {
                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'code' => $model->code,
                    'meta' => [
                        'section' => $model->sections,
                        'room' => $model->room,
                        'subject' => $model->subject,
                        'cover_image_url' => $model->cover_image_url,
                        'students_count' => $model->students_count ?? 0, // Fixed typo here
                        'theme' => $model->theme,
                    ],
                    'user' => [
                        'name' => $model->user?->name,
                    ],
                ];
            }),
        ];
        return [
            'data' => $this->collection,
        ];
    }
}

//  public function toArray(Request $request): array

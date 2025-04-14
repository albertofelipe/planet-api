<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanetCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            "data" => parent::toArray($request),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'next_page' => $this->nextPageUrl(),
                'previous_page' => $this->previousPageUrl(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'last_page' => $this->lastPage(),
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanetUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->method();

        if($method == 'PUT'){
            return [
                'name' => ['required', 'string'],
                'climate' => ['required', 'string'],
                'terrain' => ['required', 'string'],
            ];
        }
        
        return [
            'name' => ['sometimes', 'required', 'string'],
            'climate' => ['sometimes', 'required', 'string'],
            'terrain' => ['sometimes', 'required', 'string'],
        ];
    }
}

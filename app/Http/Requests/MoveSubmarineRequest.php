<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveSubmarineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'x' => [
                'required',
                'integer',
            ],
            'y' => [
                'required',
                'integer',
            ],
        ];
    }
}

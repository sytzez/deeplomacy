<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttackSubmarineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'submarine' => [
                'required',
                'exists:submarines,id',
            ],
        ];
    }
}

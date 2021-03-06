<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiveActionPointsRequest extends FormRequest
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
            'submarine' => [
                'required',
                'exists:submarines,id',
            ],
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}

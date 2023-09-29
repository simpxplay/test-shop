<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
            ],
            'price' => [
                'required',
                'integer',
            ],
            'file' => [
                'sometimes',
                'file'
            ]
        ];
    }
}

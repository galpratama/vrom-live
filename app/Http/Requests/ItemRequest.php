<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'brand_id' => 'required|exists:brands,id',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'features' => 'nullable|string',
            'price' => 'required|numeric',
            'star' => 'nullable|numeric',
            'review' => 'nullable|numeric',
        ];
    }
}

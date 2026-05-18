<?php 

namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;


class CheckOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'Latitude is required.',
            'latitude.numeric' => 'Latitude must be a numeric value.',
            'longitude.required' => 'Longitude is required.',
            'longitude.numeric' => 'Longitude must be a numeric value.',
            'photo.image' => 'The photo must be an image file.',
            'photo.max' => 'The photo may not be greater than 2MB.',
        ];
    }
}

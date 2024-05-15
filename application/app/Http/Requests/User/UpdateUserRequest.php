<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming authorization is handled elsewhere (e.g., middleware)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'prefixname' => 'nullable|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'nullable|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user->id),
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maximum size 2MB (adjust as needed)
            'type' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom validation messages for attributes.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.image' => 'The photo must be an image file.',
            'photo.mimes' => 'The photo must be a JPEG, PNG, JPG, or GIF file.',
            'photo.max' => 'The photo must be no larger than 2 megabytes.',
        ];
    }
}

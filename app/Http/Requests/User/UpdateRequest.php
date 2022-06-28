<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'username' => $this->input('username') !== $user->username ? 'bail|required|string|max:255|unique:users' : '',
            'password' => 'bail|nullable|string|max:255',
            'name' => 'bail|required|string|max:255',
            'is_active' => 'bail|required|boolean'
        ];
    }
}

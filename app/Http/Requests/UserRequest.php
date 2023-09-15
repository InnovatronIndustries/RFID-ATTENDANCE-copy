<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->isMethod('PATCH') ? ',' . $this->request->get('user_id') : '';

        $rules = [];
        $rules['role_id'] = 'required|numeric';
        $rules['firstname'] = 'required|max:150';
        $rules['middlename'] = 'nullable|max:150';
        $rules['lastname'] = 'required|max:150';
        $rules['avatar'] = 'nullable|mimes:jpeg,jpg,png,png,bmp|max:4096';
        $rules['email'] = 'nullable|email|unique:users,email'.$userId;

        if (!$userId) {
            $rules['password'] = 'required|required_with:password_confirmation';
            $rules['password_confirmation'] = 'same:password|min:6';
        }

        return $rules;
    }
}

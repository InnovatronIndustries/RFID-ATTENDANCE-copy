<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $schoolID = $this->isMethod('PATCH') ? ',' . $this->request->get('school_id') : '';
        
        return [
            'name' => 'required|unique:schools,name'.$schoolID,
            'address' => 'required',
            'logo' => 'nullable|mimes:jpeg,jpg,png,png,bmp|max:4096',
            'banner' => 'nullable|mimes:jpeg,jpg,png,png,bmp|max:4096',
            'rfid_subdomain' => 'required',
        ];
    }
}

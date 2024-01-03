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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // Validation rules for "create" scenario
            return [
            "personal_info.id_prefix" => "sometimes:required|min:1|regex:/[^\s]/",
            "personal_info.id_no" => [
                "sometimes:required",
                "unique:users,id_no",
                "min:1",
                "regex:/[^\s]/"
            ],
            "personal_info.first_name" => "sometimes:required|min:1|regex:/[^\s]/", 
            "personal_info.last_name" => "sometimes:required|min:1|regex:/[^\s]/",
            "personal_info.sex" => "sometimes:required|min:1|regex:/[^\s]/",
            "username" => [
                "sometimes:required",
                "unique:users,username," . $this->route()->user,
                "min:1",
                "regex:/[^\s]/"
            ],
            // "location_id" => "sometimes|required|exists:locations,sync_id",
            // "department_id" => "sometimes|required|exists:departments,sync_id",
            // "company_id" => "sometimes|required|exists:companies,sync_id",
            "role_id" => ["sometimes:required|exists:role_management,id|min:1|regex:/[^\s]/"]
        ];
    }

}

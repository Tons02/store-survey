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
        $createRules = [
            "personal_info.id_prefix" => "required",
            "personal_info.id_no" => [
                "required",
                "unique:users,id_no",
            ],
            "personal_info.first_name" => "required",
            "personal_info.middle_name" => "required",
            "personal_info.last_name" => "required",
            "personal_info.sex" => "required",
            "username" => [
                "required",
                "unique:users,username",
            ],
            "password" => "required",
            "location_id" => "required",
            "department_id" => "required",
            "company_id" => "required",
            "role_id" => "required"
        ];
    
        // Validation rules for "update" scenario
        $updateRules = [
            "username" => [
                "required",
                "unique:users,username," . $this->route()->user,
            ],
            "role_id" => "required"
        ];
    
        // Return the appropriate rules based on the scenario
        return $this->isMethod('patch') ? $updateRules : $createRules;
    }

}

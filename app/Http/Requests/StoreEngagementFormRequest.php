<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEngagementFormRequest extends FormRequest
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
    public function rules(): array
{
    return [
        "id" => [
            "sometimes:required",
            "string",
            $this->route()->storeengagementform
                ? "unique:store_engagement_forms,id," . $this->route()->storeengagementform
                : "unique:store_engagement_forms,id",
        ],
        "name" => "sometimes:required",
        "contact" => ["sometimes", "required", "regex:/^\+639\d{9}$/"],
        "store_name" => "sometimes:required",
        "leader" => "sometimes:required",
        "objectives" => "sometimes:required",
        "strategies" => "sometimes:required",
        "activities" => "sometimes:required",
        "findings" => "sometimes:required",
        "notes" => "sometimes:required",
        "e_signature" => "sometimes:required",
    ];
    
}

}

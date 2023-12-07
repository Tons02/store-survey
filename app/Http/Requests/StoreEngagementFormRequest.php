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
        "visit_number" => [
            "sometimes|required",
            "string",
            $this->route()->storeengagementforms
                ? "unique:store_engagement_forms,visit_number," . $this->route()->storeengagementforms
                : "unique:store_engagement_forms,visit_number",
        ],
        "name" => "sometimes|required",
        "contact" => "sometimes|required",
        "store_name" => "sometimes|required",
        "leader" => "sometimes|required",
        "date" => "sometimes|required",
        "objectives" => "sometimes|required",
        "strategies" => "sometimes|required",
        "activities" => "sometimes|required",
        "findings" => "sometimes|required",
        "notes" => "sometimes|required",
        "e_signature" => "sometimes|required",
    ];
}

}

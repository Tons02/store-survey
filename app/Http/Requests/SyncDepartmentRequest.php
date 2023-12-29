<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncDepartmentRequest extends FormRequest
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
            "sync_id" => "required",
            "code" => "required",
            "name" => "required",
            "company_sync_id" => "required|exists:companies,sync_id",
            "is_active" => "required",
            "deleted_at" => "nullable",
        ];
    }    
}

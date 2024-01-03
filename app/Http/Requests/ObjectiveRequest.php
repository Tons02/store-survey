<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ObjectiveRequest extends FormRequest
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
            "objective" => [
                "required",
                Rule::unique('objectives')->where(function ($query) {
                    return $query->where('objective', $this->input('objective'))
                                 ->where('location_id', $this->input('location_id'));
                }),
                "min:1",
                "regex:/[^\s]/"
            ],
            "location_id" => "required|exists:locations,sync_id",
        ];
        
    }
}

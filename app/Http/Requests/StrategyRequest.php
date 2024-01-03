<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StrategyRequest extends FormRequest
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
            "objective_id" => [
                "required",
                Rule::unique('strategies')->ignore($this->route('strategy'))->where(function ($query) {
                    return $query->where('objective_id', $this->input('objective_id'))
                                 ->where('strategy', $this->input('strategy'));
                }),
                "min:1",
                "regex:/[^\s]/",
                "exists:objectives,id"
            ],
            "strategy" => [
                "required",
            ],
        ];
        
    }
}

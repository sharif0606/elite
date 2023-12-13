<?php

namespace App\Http\Requests\Stock\ProductIssue;

use Illuminate\Foundation\Http\FormRequest;

class AddProductIssue extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'manual_employee_id'=>'nullable|unique:employees,admission_id_no',
        ];
    }
    public function messages(){
        return [
            'required' => "The filed is required",
            'unique' => "This Employee Id is already used. Please try another",
        ];
    }
}

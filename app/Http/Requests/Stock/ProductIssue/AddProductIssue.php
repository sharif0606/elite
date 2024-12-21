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
            'manual_employee_id' => 'nullable|unique:employees,admission_id_no',
            'employee_id' => 'nullable|unique:employees,admission_id_no',
            'company_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // If company_id is provided, employee_id or manual_employee_id should not be used
                    if ($value && ($this->input('manual_employee_id') || $this->input('employee_id'))) {
                        $fail('You cannot use both Company ID and Employee IDs (manual or regular) at the same time.');
                    }
                }
            ],
            'manual_employee_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // If manual_employee_id is provided, company_id should not be used
                    if ($value && $this->input('company_id')) {
                        $fail('You cannot use both Manual Employee ID and Company ID at the same time.');
                    }
                }
            ],
            'employee_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // If employee_id is provided, company_id should not be used
                    if ($value && $this->input('company_id')) {
                        $fail('You cannot use both Employee ID and Company ID at the same time.');
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'manual_employee_id.required' => "The Manual Employee ID field is required",
            'manual_employee_id.unique' => "This Manual Employee ID is already used. Please try another",
            'employee_id.required' => "The Employee ID field is required",
            'employee_id.unique' => "This Employee ID is already used. Please try another",
            'company_id.required' => "The Company ID is required",
            'company_id.unique' => "This Company ID is already used. Please try another",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if at least one of manual_employee_id, employee_id, or company_id is selected
            if (empty($this->input('manual_employee_id')) && empty($this->input('employee_id')) && empty($this->input('company_id'))) {
                $validator->errors()->add('manual_employee_id', 'You must select at least one of the fields: Employee ID, Manual Employee ID, or Company ID.');
            }
        });
    }
}

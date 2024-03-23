<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeeRequest extends FormRequest
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
            'bn_applicants_name' => 'required',
            'admission_id_no'=>'required|unique:employees,admission_id_no',
            'bn_jobpost_id' => 'required',
            // 'bn_parm_district_id' => 'required',
            // 'bn_parm_upazila_id' => 'required',
            // 'bn_parm_union_id' => 'required',
            // 'bn_parm_ward_id' => 'required',
            // 'bn_parm_holding_name' => 'required',
            // 'bn_parm_village_name' => 'required',
            // 'bn_parm_post_ofc' => 'required',
            // 'bn_pre_district_id' => 'required',
            // 'bn_pre_upazila_id' => 'required',
            // 'bn_pre_union_id' => 'required',
            // 'bn_pre_ward_no' => 'required',
            // 'bn_pre_holding_no' => 'required',
            // 'bn_pre_village_name' => 'required',
            // 'bn_pre_post_ofc' => 'required',
            // 'bn_identification_mark' => 'required',
            // 'bn_edu_qualification' => 'required',
            // 'bn_birth_certificate' => 'required',
            // 'bn_nationality' => 'required',
            // 'bn_religion' => 'required',
            // 'bn_marital_status' => 'required',
            // 'bn_reference_admittee' => 'required',
            // 'bn_reference_adm_phone' => 'required',
            // 'bn_reference_adm_adress' => 'required',
        ];
    }

    public function messages(){
        return [
            'required' => "The filed is required",
            'unique' => "This :attribute is already used. Please try another",
        ];
    }
}

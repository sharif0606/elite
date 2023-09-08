<?php

namespace App\Http\Requests\Vehicle\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class AddNewRequest extends FormRequest
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
            //'name'=>'required',
            'stock_id'=>'required|unique:vehicles,stock_id',
            'brand_id'=>'required',
            'sub_brand_id'=>'required',
            //'year'=>'required',
        ];
    }

    public function messages(){
        return [
            'required' => "The :attribute field is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}

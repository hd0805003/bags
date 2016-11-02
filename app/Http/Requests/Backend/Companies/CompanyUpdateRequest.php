<?php

namespace App\Http\Requests\Backend\Companies;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|unique:companies,user_id,'.$this->route('company')->id,
            'name' => 'required|unique:companies,name,'.$this->route('company')->id
        ];
    }
}
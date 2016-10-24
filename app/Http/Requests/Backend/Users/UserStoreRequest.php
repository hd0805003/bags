<?php

namespace App\Http\Requests\Backend\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'username' => 'required|alpha_dash_except_num',
            'mobile' => 'required|is_mobile',
            'password' => 'required|min:6|confirmed',
        ];
    }
}

<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class JoinStoreRequest extends FormRequest
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
            'identity_card' => 'required',
            'licenses' => 'required'
        ];
    }
}

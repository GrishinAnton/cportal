<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPersonalRequest extends FormRequest
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
            'teamlead_id' => 'required|exists:personal,pers_id'
        ];
    }
}

<?php

namespace App\Http\Requests;

class AddPersonalRequest extends Request
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
            'teamlead_id' => 'sometimes|nullable|exists:personal,pers_id'
        ];
    }
}

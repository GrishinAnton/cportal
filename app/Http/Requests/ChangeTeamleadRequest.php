<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeTeamleadRequest extends FormRequest
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
            'action'                    => 'required|in:change,delete',
            'group_id'                  => 'required|exists:personal_groups,id',
            'new_teamlead_id'           => 'required|exists:personal,pers_id',
        ];
    }
}

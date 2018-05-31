<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalFilterRequest extends FormRequest
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
            'company.*.' => 'sometimes|exists:personal_companies,id',
            'group.*.' => 'sometimes|exists:personal_groups,id',
            'year' => 'sometimes|date_format:Y',
        ];
    }
}

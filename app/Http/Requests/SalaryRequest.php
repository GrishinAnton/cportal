<?php

namespace App\Http\Requests;

class SalaryRequest extends Request
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
            'fix' => 'required|boolean',
            'salary' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'teamlead_bonus' => 'sometimes|nullable|integer',
        ];
    }
}
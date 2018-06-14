<?php

namespace App\Http\Requests\Report\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFilterRequest extends FormRequest
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
            'status.*.' => 'sometimes|exists:project_statuses,id',
        ];
    }
}

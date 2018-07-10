<?php

namespace App\Http\Requests\Report\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'status' => 'sometimes|exists:project_statuses,id',
            'company' => 'sometimes|exists:personal_companies,id',
            'start' => 'sometimes|date_format:d/m/Y',
            'finish' => 'sometimes|date_format:d/m/Y',
            'hours_laid' => 'sometimes|integer',
            'cost_per_hour' => 'sometimes|integer',
        ];
    }
}

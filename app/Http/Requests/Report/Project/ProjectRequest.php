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
            'budget' => 'required',
            'status' => 'required|exists:project_statuses,id',
            'company' => 'required|exists:personal_companies,id',
            'start' => 'required',
            'finish' => 'required',
            'hours_laid' => 'required|integer',
            'cost_per_hour' => 'required|integer',
        ];
    }
}

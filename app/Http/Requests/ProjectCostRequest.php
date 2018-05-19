<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectCostRequest extends FormRequest
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
            'projectId.*.' => 'required|exists:projects,project_id',
            'projectCost.*.' => 'required|integer',
            'worktime.*.' => 'required|integer',
            'percent.*.' => 'required|numeric|max:100',
            'costOverride.*.' => 'required|integer',
            'date.*.' => 'required|date_format:Y-m-d',
        ];
    }
}

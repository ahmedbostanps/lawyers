<?php

namespace App\Http\Requests;

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
            'name' => 'required|string|max:255',
            'client_id' => 'required',
            'client_other_name' => 'required_if:client_id,others',
            'contracts' => 'required|array',
            'contracts.*' => 'required|exists:contracts,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'اسم المشروع',
            'client_id' => 'صاحب المشروع',
            'client_other_name' => 'صاحب المشروع ( الخارجي )',
            'contracts' => 'العقود',
            'contracts.*' => 'العقود',
        ];
    }
}

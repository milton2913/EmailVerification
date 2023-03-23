<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('setting_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_title'             => [
                'string',
                'min:3',
                'max:80',
                'required',
            ],
            'meta_description'       => [
                'string',
                'required',
            ],
            'meta_keywords'          => [
                'string',
                'nullable',
            ],
            'site_email'             => [
                'required',
            ],
            'site_phone_number'      => [
                'string',
                'nullable',
            ],
            'google_analytics'       => [
                'string',
                'nullable',
            ],
            'maintenance_mode'       => [
                'required',
            ],
            'maintenance_mode_title' => [
                'string',
                'nullable',
            ],
            'copyright'              => [
                'string',
                'required',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Benefit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBenefitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('benefit_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:benefits,title,' . request()->route('benefit')->id,
            ],
        ];
    }
}

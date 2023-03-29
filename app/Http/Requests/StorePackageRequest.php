<?php

namespace App\Http\Requests;

use App\Models\Package;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePackageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('package_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'price' => [
                'numeric',
                'required',
            ],
            'email_verification_limit' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'is_active' => [
                'required',
            ],
            'duration' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'is_activated_duration' => [
                'required',
            ],
            'benefits.*' => [
                'integer',
            ],
            'benefits' => [
                'required',
                'array',
            ],
        ];
    }
}

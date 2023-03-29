<?php

namespace App\Http\Requests;

use App\Models\Purchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'purchase_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'expiration_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'email_verification_limit' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'limit_used' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}

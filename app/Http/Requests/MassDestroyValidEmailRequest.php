<?php

namespace App\Http\Requests;

use App\Models\ValidEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyValidEmailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('valid_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:valid_emails,id',
        ];
    }
}

@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.validEmail.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.valid-emails.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.id') }}
                        </th>
                        <td>
                            {{ $validEmail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.name') }}
                        </th>
                        <td>
                            {{ $validEmail->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.email') }}
                        </th>
                        <td>
                            {{ $validEmail->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.is_company') }}
                        </th>
                        <td>
                            {{ App\Models\ValidEmail::IS_COMPANY_SELECT[$validEmail->is_company] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.company_name') }}
                        </th>
                        <td>
                            {{ $validEmail->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.street') }}
                        </th>
                        <td>
                            {{ $validEmail->street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.city') }}
                        </th>
                        <td>
                            {{ $validEmail->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.zip_code') }}
                        </th>
                        <td>
                            {{ $validEmail->zip_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.country') }}
                        </th>
                        <td>
                            {{ $validEmail->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.job_position') }}
                        </th>
                        <td>
                            {{ $validEmail->job_position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.phone') }}
                        </th>
                        <td>
                            {{ $validEmail->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.mobile') }}
                        </th>
                        <td>
                            {{ $validEmail->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.tags') }}
                        </th>
                        <td>
                            {{ $validEmail->tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.reference') }}
                        </th>
                        <td>
                            {{ $validEmail->reference }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\ValidEmail::IS_ACTIVE_SELECT[$validEmail->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.validEmail.fields.user') }}
                        </th>
                        <td>
                            {{ $validEmail->user->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.valid-emails.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection

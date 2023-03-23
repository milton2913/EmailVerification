@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.validEmail.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.valid-emails.update", [$validEmail->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">{{ trans('cruds.validEmail.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $validEmail->name) }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.validEmail.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $validEmail->email) }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.validEmail.fields.is_company') }}</label>
                    <select class="form-control {{ $errors->has('is_company') ? 'is-invalid' : '' }}" name="is_company" id="is_company">
                        <option value disabled {{ old('is_company', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\ValidEmail::IS_COMPANY_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_company', $validEmail->is_company) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_company'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_company') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.is_company_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="company_name">{{ trans('cruds.validEmail.fields.company_name') }}</label>
                    <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $validEmail->company_name) }}">
                    @if($errors->has('company_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('company_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.company_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="street">{{ trans('cruds.validEmail.fields.street') }}</label>
                    <textarea class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" name="street" id="street">{{ old('street', $validEmail->street) }}</textarea>
                    @if($errors->has('street'))
                        <div class="invalid-feedback">
                            {{ $errors->first('street') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.street_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="city">{{ trans('cruds.validEmail.fields.city') }}</label>
                    <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $validEmail->city) }}">
                    @if($errors->has('city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="zip_code">{{ trans('cruds.validEmail.fields.zip_code') }}</label>
                    <input class="form-control {{ $errors->has('zip_code') ? 'is-invalid' : '' }}" type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $validEmail->zip_code) }}">
                    @if($errors->has('zip_code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('zip_code') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.zip_code_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="country">{{ trans('cruds.validEmail.fields.country') }}</label>
                    <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $validEmail->country) }}">
                    @if($errors->has('country'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.country_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="job_position">{{ trans('cruds.validEmail.fields.job_position') }}</label>
                    <input class="form-control {{ $errors->has('job_position') ? 'is-invalid' : '' }}" type="text" name="job_position" id="job_position" value="{{ old('job_position', $validEmail->job_position) }}">
                    @if($errors->has('job_position'))
                        <div class="invalid-feedback">
                            {{ $errors->first('job_position') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.job_position_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="phone">{{ trans('cruds.validEmail.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $validEmail->phone) }}">
                    @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="mobile">{{ trans('cruds.validEmail.fields.mobile') }}</label>
                    <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $validEmail->mobile) }}">
                    @if($errors->has('mobile'))
                        <div class="invalid-feedback">
                            {{ $errors->first('mobile') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.mobile_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="tags">{{ trans('cruds.validEmail.fields.tags') }}</label>
                    <input class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}" type="text" name="tags" id="tags" value="{{ old('tags', $validEmail->tags) }}">
                    @if($errors->has('tags'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tags') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.tags_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="reference">{{ trans('cruds.validEmail.fields.reference') }}</label>
                    <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', $validEmail->reference) }}">
                    @if($errors->has('reference'))
                        <div class="invalid-feedback">
                            {{ $errors->first('reference') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.reference_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.validEmail.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\ValidEmail::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $validEmail->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.is_active_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.validEmail.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $entry)
                            <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $validEmail->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.validEmail.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

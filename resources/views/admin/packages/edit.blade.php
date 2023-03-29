@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.package.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.packages.update", [$package->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.package.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $package->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.package.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $package->price) }}" step="0.01" required>
                    @if($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.price_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email_verification_limit">{{ trans('cruds.package.fields.email_verification_limit') }}</label>
                    <input class="form-control {{ $errors->has('email_verification_limit') ? 'is-invalid' : '' }}" type="number" name="email_verification_limit" id="email_verification_limit" value="{{ old('email_verification_limit', $package->email_verification_limit) }}" step="1" required>
                    @if($errors->has('email_verification_limit'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email_verification_limit') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.email_verification_limit_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.package.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active" required>
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Package::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $package->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.is_active_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="duration">{{ trans('cruds.package.fields.duration') }}</label>
                    <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', $package->duration) }}" step="1">
                    @if($errors->has('duration'))
                        <div class="invalid-feedback">
                            {{ $errors->first('duration') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.duration_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.package.fields.is_activated_duration') }}</label>
                    <select class="form-control {{ $errors->has('is_activated_duration') ? 'is-invalid' : '' }}" name="is_activated_duration" id="is_activated_duration" required>
                        <option value disabled {{ old('is_activated_duration', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Package::IS_ACTIVATED_DURATION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_activated_duration', $package->is_activated_duration) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_activated_duration'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_activated_duration') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.is_activated_duration_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="benefits">{{ trans('cruds.package.fields.benefit') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('benefits') ? 'is-invalid' : '' }}" name="benefits[]" id="benefits" multiple required>
                        @foreach($benefits as $id => $benefit)
                            <option value="{{ $id }}" {{ (in_array($id, old('benefits', [])) || $package->benefits->contains($id)) ? 'selected' : '' }}>{{ $benefit }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('benefits'))
                        <div class="invalid-feedback">
                            {{ $errors->first('benefits') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.package.fields.benefit_helper') }}</span>
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

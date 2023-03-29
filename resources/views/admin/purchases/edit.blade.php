@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.purchase.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.purchases.update", [$purchase->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.purchase.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $entry)
                            <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $purchase->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="package_id">{{ trans('cruds.purchase.fields.package') }}</label>
                    <select class="form-control select2 {{ $errors->has('package') ? 'is-invalid' : '' }}" name="package_id" id="package_id">
                        @foreach($packages as $id => $entry)
                            <option value="{{ $id }}" {{ (old('package_id') ? old('package_id') : $purchase->package->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('package'))
                        <div class="invalid-feedback">
                            {{ $errors->first('package') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.package_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="purchase_date">{{ trans('cruds.purchase.fields.purchase_date') }}</label>
                    <input class="form-control datetime {{ $errors->has('purchase_date') ? 'is-invalid' : '' }}" type="text" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date) }}" required>
                    @if($errors->has('purchase_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('purchase_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.purchase_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="expiration_date">{{ trans('cruds.purchase.fields.expiration_date') }}</label>
                    <input class="form-control datetime {{ $errors->has('expiration_date') ? 'is-invalid' : '' }}" type="text" name="expiration_date" id="expiration_date" value="{{ old('expiration_date', $purchase->expiration_date) }}">
                    @if($errors->has('expiration_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('expiration_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.expiration_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="email_verification_limit">{{ trans('cruds.purchase.fields.email_verification_limit') }}</label>
                    <input class="form-control {{ $errors->has('email_verification_limit') ? 'is-invalid' : '' }}" type="number" name="email_verification_limit" id="email_verification_limit" value="{{ old('email_verification_limit', $purchase->email_verification_limit) }}" step="1">
                    @if($errors->has('email_verification_limit'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email_verification_limit') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.email_verification_limit_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="limit_used">{{ trans('cruds.purchase.fields.limit_used') }}</label>
                    <input class="form-control {{ $errors->has('limit_used') ? 'is-invalid' : '' }}" type="number" name="limit_used" id="limit_used" value="{{ old('limit_used', $purchase->limit_used) }}" step="1">
                    @if($errors->has('limit_used'))
                        <div class="invalid-feedback">
                            {{ $errors->first('limit_used') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.limit_used_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.purchase.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Purchase::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $purchase->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.purchase.fields.is_active_helper') }}</span>
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

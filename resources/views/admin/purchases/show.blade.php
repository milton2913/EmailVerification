@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.purchase.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.id') }}
                        </th>
                        <td>
                            {{ $purchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.user') }}
                        </th>
                        <td>
                            {{ $purchase->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.package') }}
                        </th>
                        <td>
                            {{ $purchase->package->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_date') }}
                        </th>
                        <td>
                            {{ $purchase->purchase_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.expiration_date') }}
                        </th>
                        <td>
                            {{ $purchase->expiration_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.email_verification_limit') }}
                        </th>
                        <td>
                            {{ $purchase->email_verification_limit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.limit_used') }}
                        </th>
                        <td>
                            {{ $purchase->limit_used }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Purchase::IS_ACTIVE_SELECT[$purchase->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection

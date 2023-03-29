@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.package.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.id') }}
                        </th>
                        <td>
                            {{ $package->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.name') }}
                        </th>
                        <td>
                            {{ $package->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.price') }}
                        </th>
                        <td>
                            {{ $package->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.email_verification_limit') }}
                        </th>
                        <td>
                            {{ $package->email_verification_limit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Package::IS_ACTIVE_SELECT[$package->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.duration') }}
                        </th>
                        <td>
                            {{ $package->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.is_activated_duration') }}
                        </th>
                        <td>
                            {{ App\Models\Package::IS_ACTIVATED_DURATION_SELECT[$package->is_activated_duration] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.benefit') }}
                        </th>
                        <td>
                            @foreach($package->benefits as $key => $benefit)
                                <span class="label label-info">{{ $benefit->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#package_purchases" role="tab" data-toggle="tab">
                    {{ trans('cruds.purchase.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="package_purchases">
                @includeIf('admin.packages.relationships.packagePurchases', ['purchases' => $package->packagePurchases])
            </div>
        </div>
    </div>

@endsection

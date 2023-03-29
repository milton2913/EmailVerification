@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.benefit.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.benefits.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.id') }}
                        </th>
                        <td>
                            {{ $benefit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.title') }}
                        </th>
                        <td>
                            {{ $benefit->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.benefit.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Benefit::IS_ACTIVE_SELECT[$benefit->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.benefits.index') }}">
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
                <a class="nav-link" href="#benefit_packages" role="tab" data-toggle="tab">
                    {{ trans('cruds.package.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="benefit_packages">
                @includeIf('admin.benefits.relationships.benefitPackages', ['packages' => $benefit->benefitPackages])
            </div>
        </div>
    </div>

@endsection

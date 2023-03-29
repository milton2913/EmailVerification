@extends('layouts.admin')
@section('content')
    @can('purchase_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.purchases.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.purchase.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.purchase.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Purchase">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.package') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.purchase_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.expiration_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.email_verification_limit') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.limit_used') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchase.fields.is_active') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.purchases.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'package_name', name: 'package.name' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'expiration_date', name: 'expiration_date' },
                    { data: 'email_verification_limit', name: 'email_verification_limit' },
                    { data: 'limit_used', name: 'limit_used' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Purchase').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });

    </script>
@endsection

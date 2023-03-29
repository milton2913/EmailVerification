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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-packagePurchases">
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
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchases as $key => $purchase)
                    <tr data-entry-id="{{ $purchase->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $purchase->id ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->package->name ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->purchase_date ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->expiration_date ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->email_verification_limit ?? '' }}
                        </td>
                        <td>
                            {{ $purchase->limit_used ?? '' }}
                        </td>
                        <td>
                            @can('purchase_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.purchases.show', $purchase->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('purchase_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.purchases.edit', $purchase->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan


                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-packagePurchases:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection

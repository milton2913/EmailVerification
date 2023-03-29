@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            {{--                <form method="POST" action="{{ route("buyer.singleVerify") }}" enctype="multipart/form-data">--}}
            @include('buyer.single-verify-form')

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            List of Tasks
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-AuditLog">
                    <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            Task Id
                        </th>
                        <th>
                            Task Date
                        </th>
                        <th>
                            Task Name
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Total Emails
                        </th>
                        <th>
                            Progress
                        </th>
                        <th>
                            &nbsp;Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bulks as $key => $task)
                        <tr data-entry-id="{{ $task->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $task->id ?? '' }}
                            </td>
                            <td>

                                {{ \Carbon\Carbon::parse($task->created_at)->format(' h:i A, j  F , Y') }}
                            </td>
                            <td>
                                {{ $task->name ?? '' }}
                            </td>
                            <td>
                                {{ $task->status ?? '' }}
                            </td>
                            <td>
                                {{ $task->total ?? '' }}
                            </td>
                            <td>
                                {{ $task->progress ?? '' }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('buyer.tasksReport', $task->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@endsection
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
            let table = $('.datatable-AuditLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection

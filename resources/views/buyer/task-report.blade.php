@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
{{--                <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">--}}
                    <form id="my-form" action="{{ route("buyer.singleVerify") }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="email" id="email" value="{{ old('email', '') }}" required>
                        <div class="input-group-prepend">
                            <button  type="submit" class="btn btn-dark">Verify</button>
                        </div>
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
                    </div>

                </form>

            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Report: {{ $bulk->name??'' }}
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <p><strong>{{ "Task ID:" }}</strong>{{ $bulk->id }}</p>
                                <p><strong>{{ "Status:" }}</strong>{{ $bulk->status }}</p>
                                <p><strong>{{ "Progress:" }}</strong>{{ $bulk->progress }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ "Start Date & Time:" }}</strong>{{ \Carbon\Carbon::parse($bulk->created_at)->format(' h:i A, j  F , Y') }}</p>
                                <p><strong>{{ "End Date & Time :" }}</strong>{{ \Carbon\Carbon::parse($bulk->updated_at)->format(' h:i A, j  F , Y') }}</p>
                                <p><strong>{{ "Runtime:" }}</strong>{{ $bulk->run_time }}</p>
                            </div>

                        </div>
                        <div id="totalOverview"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Report: {{ $bulk->name??'' }}
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <p><strong>{{ "Task ID:" }}</strong>{{ $bulk->id }}</p>
                                <p><strong>{{ "Status:" }}</strong>{{ $bulk->status }}</p>
                                <p><strong>{{ "Progress:" }}</strong>{{ $bulk->progress }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ "Start Date & Time:" }}</strong>{{ \Carbon\Carbon::parse($bulk->created_at)->format(' h:i A, j  F , Y') }}</p>
                                <p><strong>{{ "End Date & Time :" }}</strong>{{ \Carbon\Carbon::parse($bulk->updated_at)->format(' h:i A, j  F , Y') }}</p>
                                <p><strong>{{ "Runtime:" }}</strong>{{ $bulk->run_time }}</p>
                            </div>

                        </div>
                        <div id="totalOverview"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        List of Emails & Download
                    </div>
                    <div class="card-body">
                        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ValidEmail">
                            <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>
                                    {{ trans('cruds.validEmail.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.validEmail.fields.email') }}
                                </th>
                                <th>
                                    Email Status
                                </th>
                                <th>
                                    Email Score
                                </th>
                                <th>
                                    Email Checking Time
                                </th>
                                <th>
                                    {{ trans('cruds.validEmail.fields.user') }}
                                </th>

                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>

                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($users as $key => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    <style>
        #totalOverview {
            width: 100%;
            height: 500px;
        }
    </style>
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>
@endpush
@push('script')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <!-- Chart code -->
    <script>
        var overviews = {!! json_encode($overviews) !!};
        var total = {!! json_encode($total) !!};
        am4core.ready(function() {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
            var chart = am4core.create("totalOverview", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart.data = overviews;
// Add label
            if (total === 0) {
                // Create a new chart with a default value of "No data available"
                var chart = am4core.create("totalOverview", am4charts.PieChart3D);
                chart.innerRadius = 100;
                var label = chart.seriesContainer.createChild(am4core.Label);
                label.text = "No data available";
                label.horizontalCenter = "middle";
                label.verticalCenter = "middle";
                label.fontSize = 30;
                label.y = -20;
                label.multiline = true;
                label.textAlign = "center";
            }else{
                chart.innerRadius = 100;
                var label = chart.seriesContainer.createChild(am4core.Label);
                label.text = "Total\n{{ $total }}"; // use \n instead of <br>
                label.horizontalCenter = "middle";
                label.verticalCenter = "middle";
                label.fontSize = 30;
                label.y = -25; // move label 20 pixels upwards from the center
                label.multiline = true; // enable multiline text
                label.textAlign = "center"; // center-align the text within the label
            }
            chart.innerRadius = am4core.percent(45);
                chart.depth = 20;
            chart.legend = new am4charts.Legend();
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "value";
            series.dataFields.depthValue = "value";
            series.dataFields.category = "category";
            series.slices.template.cornerRadius = 5;
            series.colors.step = 3;
        }); // end am4core.ready()

    </script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#my-form').submit(function(event) {
                event.preventDefault();
                $('#verification-email').html($('#email').val());
                Swal.fire({
                    title: 'Email Verification',
                    html: '<p>Are you sure you want to verify this email?</p><p><strong>' + $('#email').val() + '</strong></p>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing',
                            text: 'Verifying email, please wait...',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $.ajax({
                            type: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            success: function(response) {
                                var detailsHtml = '';
                                for (var key in response.details) {
                                    detailsHtml += '<p><strong>' + key + ':</strong> ' + response.details[key] + '</p>';
                                }
                                Swal.fire({
                                    title: response.message == 'VALID' ? 'VALID' : 'INVALID',
                                    html: detailsHtml,
                                    icon: response.message == 'VALID' ? 'success' : 'error'
                                });
                                $('#processing-message').hide();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred while verifying the email',
                                    icon: 'error'
                                });
                                $('#my-modal').modal('hide');
                            },
                            complete: function() {
                                Swal.hideLoading();
                            }
                        });
                    }
                });
            });
            $('#result-modal').on('click', function() {
                $(this).modal('hide');
            });
        });
    </script>

{{--    for datatable--}}
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('valid_email_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.valid-emails.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('buyer.tasksEmails',[$bulk->id]) }}",
                {{--ajax: "{{ route('admin.valid-emails.index') }}",--}}
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'id', name: 'id' },
                    { data: 'email', name: 'email' },
                    { data: 'is_valid_email', name: 'is_valid_email' },
                    { data: 'email_score', name: 'email_score' },
                    { data: 'process_time', name: 'process_time' },
                    { data: 'user_name', name: 'user.name' },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-ValidEmail').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });

    </script>
@endpush

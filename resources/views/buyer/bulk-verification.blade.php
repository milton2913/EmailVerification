@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
{{--                <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">--}}
                @include('buyer.single-verify-form')


            </div>



            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form id="bulkVerify" action="{{ route("buyer.bulkVerify") }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="text" value="{{ old('name', '') }}" required>
                                @if($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <textarea id="emails" name="emails" class="form-control {{ $errors->has('list_of_email') ? 'is-invalid' : '' }}" rows="10" required>

                                </textarea>

                                @if($errors->has('list_of_email'))
                                    <span class="text-danger">{{ $errors->first('list_of_email') }}</span>
                                @endif

                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="bulk_type" id="bulk_type" value="Task" required>
                                    <button  type="submit" class="btn btn-dark">Start Verification</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Lifetime Usage Statistics
                    </div>

                    <div class="card-body">
<ul>
    @foreach($bulks as $bulk)
        <li>
<a href="{{ route('buyer.startVerify',[$bulk->id,strtolower($bulk->bulk_type)]) }}">{{ $bulk->name }}</a>
        </li>
    @endforeach

</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')

@endpush
@push('script')

    <script>
        $(document).ready(function() {
            /////// bulk task form
            $('#bulkVerify').submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Email Verification',
                    html: '<p>Are you sure you want to verify list of emails?</p>',
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
        });
    </script>
@endpush

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

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
@endpush
@push('script')
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
                                    title: response.message=='NOTICE'?'NOTICE':(response.message == 'VALID' ? 'VALID' : 'INVALID'),
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
@endpush

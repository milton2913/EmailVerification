@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.settings.update", [1]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="logo">{{ trans('cruds.setting.fields.logo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                    </div>
                    @if($errors->has('logo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('logo') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.logo_helper') }}</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="favicon">{{ trans('cruds.setting.fields.favicon') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('favicon') ? 'is-invalid' : '' }}" id="favicon-dropzone">
                    </div>
                    @if($errors->has('favicon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('favicon') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.favicon_helper') }}</span>
                </div>
                <div class="form-group col-md-3">
                    <label class="required" for="site_title">{{ trans('cruds.setting.fields.site_title') }}</label>
                    <input class="form-control {{ $errors->has('site_title') ? 'is-invalid' : '' }}" type="text" name="site_title" id="site_title" value="{{ old('site_title', $setting?$setting->site_title:'') }}" required>
                    @if($errors->has('site_title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('site_title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.site_title_helper') }}</span>
                </div>
                <div class="form-group col-md-3">
                    <label class="required" for="site_email">{{ trans('cruds.setting.fields.site_email') }}</label>
                    <input class="form-control {{ $errors->has('site_email') ? 'is-invalid' : '' }}" type="email" name="site_email" id="site_email" value="{{ old('site_email', $setting?$setting->site_email:'') }}" required>
                    @if($errors->has('site_email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('site_email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.site_email_helper') }}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="site_phone_number">{{ trans('cruds.setting.fields.site_phone_number') }}</label>
                    <input class="form-control {{ $errors->has('site_phone_number') ? 'is-invalid' : '' }}" type="text" name="site_phone_number" id="site_phone_number" value="{{ old('site_phone_number', $setting?$setting->site_phone_number:'') }}">
                    @if($errors->has('site_phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('site_phone_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.site_phone_number_helper') }}</span>
                </div>
                    <div class="form-group col-md-4">
                        <label class="required" for="copyright">{{ trans('cruds.setting.fields.copyright') }}</label>
                        <input class="form-control {{ $errors->has('copyright') ? 'is-invalid' : '' }}" type="text" name="copyright" id="copyright" value="{{ old('copyright', $setting?$setting->copyright:'') }}" required>
                        @if($errors->has('copyright'))
                            <div class="invalid-feedback">
                                {{ $errors->first('copyright') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.setting.fields.copyright_helper') }}</span>
                    </div>

                    <div class="form-group col-md-12">
                    <label for="address">{{ trans('cruds.setting.fields.address') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{!! old('address', $setting?$setting->address:'') !!}</textarea>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.address_helper') }}</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="banner">{{ trans('cruds.setting.fields.banner') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('banner') ? 'is-invalid' : '' }}" id="banner-dropzone">
                    </div>
                    @if($errors->has('banner'))
                        <div class="invalid-feedback">
                            {{ $errors->first('banner') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.banner_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label for="homepage_background">{{ trans('cruds.setting.fields.homepage_background') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('homepage_background') ? 'is-invalid' : '' }}" id="homepage_background-dropzone">
                    </div>
                    @if($errors->has('homepage_background'))
                        <div class="invalid-feedback">
                            {{ $errors->first('homepage_background') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.homepage_background_helper') }}</span>
                </div>

                    <div class="form-group col-md-12">
                        <label for="summary">{{ trans('cruds.setting.fields.summary') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{!! old('summary', $setting->summary) !!}</textarea>
                        @if($errors->has('summary'))
                            <div class="invalid-feedback">
                                {{ $errors->first('summary') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.setting.fields.summary_helper') }}</span>
                    </div>

                    <div class="form-group col-md-12">
                    <label for="about">{{ trans('cruds.setting.fields.about') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{!! old('about', $setting?$setting->about:'') !!}</textarea>
                    @if($errors->has('about'))
                        <div class="invalid-feedback">
                            {{ $errors->first('about') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.about_helper') }}</span>
                </div>
                <div class="form-group col-md-4">
                    <label class="required" for="meta_keywords">{{ trans('cruds.setting.fields.meta_keywords') }}</label>
                    <input class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $setting?$setting->meta_keywords:'') }}">
                    @if($errors->has('meta_keywords'))
                        <div class="invalid-feedback">
                            {{ $errors->first('meta_keywords') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.meta_keywords_helper') }}</span>
                </div>

                <div class="form-group col-md-4">
                    <label class="required" for="meta_description">{{ trans('cruds.setting.fields.meta_description') }}</label>
                    <input class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', $setting?$setting->meta_description:'') }}" required>
                    @if($errors->has('meta_description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('meta_description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.meta_description_helper') }}</span>
                </div>

                    <div class="form-group col-md-4">
                        <label class="required">{{ trans('cruds.setting.fields.admin_approval') }}</label>
                        <select class="form-control {{ $errors->has('admin_approval') ? 'is-invalid' : '' }}" name="admin_approval" id="admin_approval" required>
                            <option value disabled {{ old('admin_approval', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Setting::ADMIN_APPROVAL_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('admin_approval', $setting?$setting->admin_approval:'') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('admin_approval'))
                            <div class="invalid-feedback">
                                {{ $errors->first('admin_approval') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.setting.fields.admin_approval_helper') }}</span>
                    </div>


                <div class="form-group col-md-4">
                    <label class="required">{{ trans('cruds.setting.fields.maintenance_mode') }}</label>
                    <select class="form-control {{ $errors->has('maintenance_mode') ? 'is-invalid' : '' }}" name="maintenance_mode" id="maintenance_mode" required>
                        <option value disabled {{ old('maintenance_mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Setting::MAINTENANCE_MODE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('maintenance_mode', $setting?$setting->maintenance_mode:'') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('maintenance_mode'))
                        <div class="invalid-feedback">
                            {{ $errors->first('maintenance_mode') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.maintenance_mode_helper') }}</span>
                </div>
                <div class="form-group col-md-4">
                    <label for="maintenance_mode_title">{{ trans('cruds.setting.fields.maintenance_mode_title') }}</label>
                    <input class="form-control {{ $errors->has('maintenance_mode_title') ? 'is-invalid' : '' }}" type="text" name="maintenance_mode_title" id="maintenance_mode_title" value="{{ old('maintenance_mode_title', $setting?$setting->maintenance_mode_title:'') }}">
                    @if($errors->has('maintenance_mode_title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('maintenance_mode_title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.maintenance_mode_title_helper') }}</span>
                </div>
                    <div class="form-group col-md-4">
                        <label for="google_analytics">{{ trans('cruds.setting.fields.google_analytics') }}</label>
                        <input class="form-control {{ $errors->has('google_analytics') ? 'is-invalid' : '' }}" type="text" name="google_analytics" id="google_analytics" value="{{ old('google_analytics', $setting?$setting->google_analytics:'') }}">
                        @if($errors->has('google_analytics'))
                            <div class="invalid-feedback">
                                {{ $errors->first('google_analytics') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.setting.fields.google_analytics_helper') }}</span>
                    </div>
                <div class="form-group col-md-12">
                    <label for="maintenance_mode_content">{{ trans('cruds.setting.fields.maintenance_mode_content') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('maintenance_mode_content') ? 'is-invalid' : '' }}" name="maintenance_mode_content" id="maintenance_mode_content">{!! old('maintenance_mode_content', $setting?$setting->maintenance_mode_content:'') !!}</textarea>
                    @if($errors->has('maintenance_mode_content'))
                        <div class="invalid-feedback">
                            {{ $errors->first('maintenance_mode_content') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.setting.fields.maintenance_mode_content_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.update') }}
                    </button>
                </div>
                </div>
            </form>



        </div>
    </div>



@endsection

@section('scripts')
    <script>
        Dropzone.options.logoDropzone = {
            url: '{{ route('admin.settings.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 300,
                height: 500
            },
            success: function (file, response) {
                console.log(response.name);
                $('form').find('input[name="logo"]').remove()
                $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
            },

            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="logo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($setting) && $setting?$setting->logo:'')
                var file = {!! json_encode($setting?$setting->logo:'') !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        Dropzone.options.faviconDropzone = {
            url: '{{ route('admin.settings.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 2000,
                height: 2000
            },
            success: function (file, response) {
                $('form').find('input[name="favicon"]').remove()
                $('form').append('<input type="hidden" name="favicon" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="favicon"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($setting) && $setting?$setting->favicon:'')
                var file = {!! json_encode($setting?$setting->favicon:'') !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="favicon" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/settings/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $setting?$setting->id:'' ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

    <script>
        Dropzone.options.bannerDropzone = {
            url: '{{ route('admin.settings.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="banner"]').remove()
                $('form').append('<input type="hidden" name="banner" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="banner"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($setting) && $setting?$setting->banner:'')
                var file = {!! json_encode($setting?$setting->banner:'') !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="banner" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        Dropzone.options.homepageBackgroundDropzone = {
            url: '{{ route('admin.settings.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="homepage_background"]').remove()
                $('form').append('<input type="hidden" name="homepage_background" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="homepage_background"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($setting) && $setting?$setting->homepage_background:'')
                var file = {!! json_encode($setting?$setting->homepage_background:'') !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="homepage_background" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        Dropzone.options.watermarkImageDropzone = {
            url: '{{ route('admin.settings.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="watermark_image"]').remove()
                $('form').append('<input type="hidden" name="watermark_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="watermark_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($setting) && $setting?$setting->watermark_image:'')
                var file = {!! json_encode($setting?$setting->watermark_image:'') !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="watermark_image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection

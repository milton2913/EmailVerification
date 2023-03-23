<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settings = Setting::with(['media'])->get();

        return view('admin.settings.index', compact('settings'));
    }

    public function edit(Setting $setting)
    {
        abort_if(Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = 1;
        $setting = Setting::find($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //$setting->update($request->all());
        $id = 1;
        $setting = Setting::where('id', $id)->first();
        if ($setting==null) {
            $setting = Setting::create($request->all());
            $message ="Your settings create successfully";
        } else {
            $setting->update($request->all());
            $message ="Your settings update successfully";
        }

        if ($request->input('favicon', false)) {
            if (!$setting->favicon || $request->input('favicon') !== $setting->favicon->file_name) {
                if ($setting->favicon) {
                    $setting->favicon->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('favicon')))->toMediaCollection('favicon');
            }
        } elseif ($setting->favicon) {
            $setting->favicon->delete();
        }

        if ($request->input('logo', false)) {
            if (!$setting->logo || $request->input('logo') !== $setting->logo->file_name) {
                if ($setting->logo) {
                    $setting->logo->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
            }
        } elseif ($setting->logo) {
            $setting->logo->delete();
        }

        if ($request->input('banner', false)) {
            if (!$setting->banner || $request->input('banner') !== $setting->banner->file_name) {
                if ($setting->banner) {
                    $setting->banner->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->toMediaCollection('banner');
            }
        } elseif ($setting->banner) {
            $setting->banner->delete();
        }

        if ($request->input('homepage_background', false)) {
            if (!$setting->homepage_background || $request->input('homepage_background') !== $setting->homepage_background->file_name) {
                if ($setting->homepage_background) {
                    $setting->homepage_background->delete();
                }

                $setting->addMedia(storage_path('tmp/uploads/' . $request->input('homepage_background')))->toMediaCollection('homepage_background');
            }
        } elseif ($setting->homepage_background) {
            $setting->homepage_background->delete();
        }

        return redirect()->route('admin.settings.edit')->with('message',$message);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('setting_create') && Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Setting();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

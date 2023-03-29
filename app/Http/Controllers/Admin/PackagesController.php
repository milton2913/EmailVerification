<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPackageRequest;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Benefit;
use App\Models\Package;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Package::with(['benefits'])->select(sprintf('%s.*', (new Package)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'package_show';
                $editGate      = 'package_edit';
                $deleteGate    = 'package_delete';
                $crudRoutePart = 'packages';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('email_verification_limit', function ($row) {
                return $row->email_verification_limit ? $row->email_verification_limit : '';
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Package::IS_ACTIVE_SELECT[$row->is_active] : '';
            });
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('is_activated_duration', function ($row) {
                return $row->is_activated_duration ? Package::IS_ACTIVATED_DURATION_SELECT[$row->is_activated_duration] : '';
            });
            $table->editColumn('benefit', function ($row) {
                $labels = [];
                foreach ($row->benefits as $benefit) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $benefit->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'benefit']);

            return $table->make(true);
        }

        return view('admin.packages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('title', 'id');

        return view('admin.packages.create', compact('benefits'));
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->all());
        $package->benefits()->sync($request->input('benefits', []));

        return redirect()->route('admin.packages.index');
    }

    public function edit(Package $package)
    {
        abort_if(Gate::denies('package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefits = Benefit::pluck('title', 'id');

        $package->load('benefits');

        return view('admin.packages.edit', compact('benefits', 'package'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->all());
        $package->benefits()->sync($request->input('benefits', []));

        return redirect()->route('admin.packages.index');
    }

    public function show(Package $package)
    {
        abort_if(Gate::denies('package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $package->load('benefits', 'packagePurchases');

        return view('admin.packages.show', compact('package'));
    }

    public function destroy(Package $package)
    {
        abort_if(Gate::denies('package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $package->delete();

        return back();
    }

    public function massDestroy(MassDestroyPackageRequest $request)
    {
        $packages = Package::find(request('ids'));

        foreach ($packages as $package) {
            $package->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

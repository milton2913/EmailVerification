<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBenefitRequest;
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Models\Benefit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Benefit::query()->select(sprintf('%s.*', (new Benefit)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_show';
                $editGate      = 'benefit_edit';
                $deleteGate    = 'benefit_delete';
                $crudRoutePart = 'benefits';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Benefit::IS_ACTIVE_SELECT[$row->is_active] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.benefits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.benefits.create');
    }

    public function store(StoreBenefitRequest $request)
    {
        $benefit = Benefit::create($request->all());

        return redirect()->route('admin.benefits.index');
    }

    public function edit(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.benefits.edit', compact('benefit'));
    }

    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        $benefit->update($request->all());

        return redirect()->route('admin.benefits.index');
    }

    public function show(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->load('benefitPackages');

        return view('admin.benefits.show', compact('benefit'));
    }

    public function destroy(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitRequest $request)
    {
        $benefits = Benefit::find(request('ids'));

        foreach ($benefits as $benefit) {
            $benefit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

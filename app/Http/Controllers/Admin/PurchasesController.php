<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Package;
use App\Models\Purchase;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchasesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Purchase::with(['user', 'package'])->select(sprintf('%s.*', (new Purchase)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'purchase_show';
                $editGate      = 'purchase_edit';
                $deleteGate    = 'purchase_delete';
                $crudRoutePart = 'purchases';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('package_name', function ($row) {
                return $row->package ? $row->package->name : '';
            });

            $table->editColumn('email_verification_limit', function ($row) {
                return $row->email_verification_limit ? $row->email_verification_limit : '';
            });
            $table->editColumn('limit_used', function ($row) {
                return $row->limit_used ? $row->limit_used : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'package']);

            return $table->make(true);
        }

        return view('admin.purchases.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packages = Package::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.purchases.create', compact('packages', 'users'));
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create($request->all());

        return redirect()->route('admin.purchases.index');
    }

    public function edit(Purchase $purchase)
    {
        abort_if(Gate::denies('purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packages = Package::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $purchase->load('user', 'package');

        return view('admin.purchases.edit', compact('packages', 'purchase', 'users'));
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());

        return redirect()->route('admin.purchases.index');
    }

    public function show(Purchase $purchase)
    {
        abort_if(Gate::denies('purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchase->load('user', 'package');

        return view('admin.purchases.show', compact('purchase'));
    }
}

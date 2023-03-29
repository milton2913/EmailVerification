<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\Admin\PurchaseResource;
use App\Models\Purchase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchasesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseResource(Purchase::with(['user', 'package'])->get());
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create($request->all());

        return (new PurchaseResource($purchase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Purchase $purchase)
    {
        abort_if(Gate::denies('purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseResource($purchase->load(['user', 'package']));
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());

        return (new PurchaseResource($purchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}

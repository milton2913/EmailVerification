<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Http\Resources\Admin\BenefitResource;
use App\Models\Benefit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BenefitsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('benefit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitResource(Benefit::all());
    }

    public function store(StoreBenefitRequest $request)
    {
        $benefit = Benefit::create($request->all());

        return (new BenefitResource($benefit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BenefitResource($benefit);
    }

    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        $benefit->update($request->all());

        return (new BenefitResource($benefit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Benefit $benefit)
    {
        abort_if(Gate::denies('benefit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

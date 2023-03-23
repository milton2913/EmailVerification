<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyValidEmailRequest;
use App\Http\Requests\StoreValidEmailRequest;
use App\Http\Requests\UpdateValidEmailRequest;
use App\Models\User;
use App\Models\ValidEmail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ValidEmailsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('valid_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        if ($request->ajax()) {
            $query = ValidEmail::with(['user', 'created_by'])->select(sprintf('%s.*', (new ValidEmail())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'valid_email_show';
                $editGate = 'valid_email_edit';
                $deleteGate = 'valid_email_delete';
                $crudRoutePart = 'valid-emails';

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
//            $table->editColumn('name', function ($row) {
//                return $row->name ? $row->name : '';
//            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('email_score', function ($row) {
                return $row->email_score ? $row->email_score : '';
            });
            $table->editColumn('process_time', function ($row) {
                return $row->email_score ? $row->process_time : '';
            });
//            $table->editColumn('is_company', function ($row) {
//                return $row->is_company ? ValidEmail::IS_COMPANY_SELECT[$row->is_company] : '';
//            });
//            $table->editColumn('company_name', function ($row) {
//                return $row->company_name ? $row->company_name : '';
//            });
//            $table->editColumn('street', function ($row) {
//                return $row->street ? $row->street : '';
//            });
//            $table->editColumn('city', function ($row) {
//                return $row->city ? $row->city : '';
//            });
//            $table->editColumn('zip_code', function ($row) {
//                return $row->zip_code ? $row->zip_code : '';
//            });
//            $table->editColumn('country', function ($row) {
//                return $row->country ? $row->country : '';
//            });
//            $table->editColumn('job_position', function ($row) {
//                return $row->job_position ? $row->job_position : '';
//            });
//            $table->editColumn('phone', function ($row) {
//                return $row->phone ? $row->phone : '';
//            });
//            $table->editColumn('mobile', function ($row) {
//                return $row->mobile ? $row->mobile : '';
//            });
//            $table->editColumn('tags', function ($row) {
//                return $row->tags ? $row->tags : '';
//            });
//            $table->editColumn('reference', function ($row) {
//                return $row->reference ? $row->reference : '';
//            });
//            $table->editColumn('is_active', function ($row) {
//                return $row->is_active ? ValidEmail::IS_ACTIVE_SELECT[$row->is_active] : '';
//            });
            $table->editColumn('is_valid_email', function ($row) {
                return ($row->is_valid_email==="1"?"Valid Email":($row->is_valid_email==="2"?"Invalid":($row->is_valid_email==="3"?"Catch All":"Process")));
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.validEmails.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('valid_email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.validEmails.create', compact('users'));
    }

    public function store(StoreValidEmailRequest $request)
    {
        $validEmail = ValidEmail::create($request->all());

        return redirect()->route('admin.valid-emails.index');
    }

    public function edit(ValidEmail $validEmail)
    {
        abort_if(Gate::denies('valid_email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $validEmail->load('user', 'created_by');

        return view('admin.validEmails.edit', compact('users', 'validEmail'));
    }

    public function update(UpdateValidEmailRequest $request, ValidEmail $validEmail)
    {
        $validEmail->update($request->all());

        return redirect()->route('admin.valid-emails.index');
    }

    public function show(ValidEmail $validEmail)
    {
        abort_if(Gate::denies('valid_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validEmail->load('user', 'created_by');

        return view('admin.validEmails.show', compact('validEmail'));
    }

    public function destroy(ValidEmail $validEmail)
    {
        abort_if(Gate::denies('valid_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validEmail->delete();

        return back();
    }

    public function massDestroy(MassDestroyValidEmailRequest $request)
    {
        $validEmails = ValidEmail::find(request('ids'));

        foreach ($validEmails as $validEmail) {
            $validEmail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

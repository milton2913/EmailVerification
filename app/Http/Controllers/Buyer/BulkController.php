<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Jobs\VerifyValidEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bulk;
use App\Models\ValidEmail;
use DB;
use Yajra\DataTables\Facades\DataTables;

class BulkController extends Controller
{

    public function bulkVerifyForm()
    {
        $bulks = Bulk::where('user_id', auth()->id())->get();
        return view('buyer.bulk-verification', compact('bulks'));
    }

    public function bulkVerify(Request $request)
    {
        $name = $request->input('name');
        $emails = $request->input('emails');
        $emails = $this->emailFilter($emails);
        // Create a new Bulk record
        $bulkData = [
            'name' => $name,
            'bulk_type' => $request->input('bulk_type'),
            'user_id' => auth()->id(),
            'status' => 'Interval',
            'total' => count($emails),
            'progress' => 0,
            'run_time' => '0',
        ];
        $bulk = Bulk::create($bulkData);
        // Prepare the email data for insertion
        $emailData = [];
        foreach ($emails as $email) {
            $emailData[] = ['email' => $email, 'user_id' => auth()->id(), 'where_to_check' => $request->input('bulk_type')];
        }

        $chunks = array_chunk($emailData, 500);

        foreach ($chunks as $chunk) {
            $insertedIds = [];
            foreach ($chunk as $email) {
                $id = ValidEmail::insertGetId($email);
                $insertedIds[] = $id;
            }
            $bulk->validEmails()->attach($insertedIds);
        }
        $verify = $this->startVerify($bulk->id);
        if ($verify === true) {
            $data = [
                'message' => "VALID",
                'details' => [
                    'status' => "VALID",
                    'message' => "Your total emails " . count($emailData) . ", please wait some times or click below link for live update",
                    'total' => count($emailData),
                    'task_type' => $request->input('bulk_type'),
                ]
            ];
        } else {
            $data = [
                'message' => "INVALID",
                'details' => [
                    'status' => "INVALID",
                    'message' => "Your email is not valid process again",
                    'total' => count($emailData),
                    'task_type' => $request->input('bulk_type'),
                ]
            ];
        }
        return $data;
//        //return redirect()->back()->with('success', 'Bulk created successfully.');
    }


    public function startVerify($id)
    {

        $userId = auth()->id();
        $bulk = Bulk::where('id', $id)->where('user_id', auth()->id())->first();
        $validEmails = $bulk->validEmails;
        foreach ($validEmails as $validEmail) {
            dispatch(new VerifyValidEmailJob($validEmail));
        }
        return true;
    }

    function emailFilter($emails)
    {
        // Define a regular expression pattern to match email addresses
        $pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';
// Use the preg_match_all function to find all matches of the pattern in the string
        if (preg_match_all($pattern, $emails, $matches)) {
            $emails = $matches[0];
            // $emails now contains an array of all email addresses found in the string
            return $emails;
        } else {
            return $emails = [];
        }
    }

    public function listOfTask()
    {
        $bulks = Bulk::where('user_id',auth()->id())->get();

        return view('buyer.list-of-tasks',compact('bulks'));
    }
    public function tasksReport($id){

$users = User::get();
        $bulk = Bulk::findOrFail($id);

        $overviews = array();
        $validEmails = $bulk->validEmails()->get(['is_valid_email', 'is_syntax_check', 'is_disposable', 'is_free_email', 'is_domain', 'is_mx_record', 'is_smtp_valid', 'is_username', 'is_catch_all', 'is_role']);

        $total = count($validEmails);
        $is_valid_email = count($validEmails->where('is_valid_email', '1'));
        $is_disposable = count($validEmails->where('is_disposable', '0'));
        $is_role = count($validEmails->where('is_role', '1'));
        $is_catch_all = count($validEmails->where('is_catch_all', '1'))-$is_role;
        $safe = $is_valid_email - ($is_catch_all + $is_role);
        $invalid = $total - $is_valid_email;
        array_push($overviews, ['category' => 'Safe', 'value' => $safe]);
        array_push($overviews, ['category' => 'Disposable', 'value' => $is_disposable]);
        array_push($overviews, ['category' => 'Catch All', 'value' => $is_catch_all]);
        array_push($overviews, ['category' => 'Role', 'value' => $is_role]);
        array_push($overviews, ['category' => 'Invalid', 'value' => $invalid]);

        return view('buyer.task-report',compact('bulk','overviews','total','users'));

    }



    public function tasksEmails(Request $request,$id){
        if ($request->ajax()) {
            $bulk = Bulk::findOrFail($id);
            $query = $bulk->validEmails()->with(['user', 'created_by'])->select(sprintf('%s.*', (new ValidEmail())->table));

//            $query = ValidEmail::with(['user', 'created_by'])->select(sprintf('%s.*', (new ValidEmail())->table));
//            $query = ValidEmail::with(['user', 'created_by'])->select(sprintf('%s.*', (new ValidEmail())->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
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
}

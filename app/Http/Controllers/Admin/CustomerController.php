<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ValidEmail;
use Illuminate\Http\Request;
use App\Services\EmailVerifier;
use Carbon\Carbon;
use DB;

class CustomerController extends Controller
{
    public function overview()
    {

        //$this->test("milton2913@gmail.com");
        $overviews = array();
        $validEmails = ValidEmail::where('user_id', auth()->id())->get(['is_valid_email', 'is_syntax_check', 'is_disposable', 'is_free_email', 'is_domain', 'is_mx_record', 'is_smtp_valid', 'is_username', 'is_catch_all', 'is_role']);

        $total = count($validEmails);
        $is_valid_email = count($validEmails->where('is_valid_email', '1'));
//        $is_syntax_check =count($validEmails->where('is_syntax_check','1'));
        $is_disposable = count($validEmails->where('is_disposable', '0'));
//        $is_domain =count($validEmails->where('is_domain','1'));
//        $is_mx_record =count($validEmails->where('is_mx_record','1'));
//        $is_smtp_valid =count($validEmails->where('is_smtp_valid','1'));
//        $is_username =count($validEmails->where('is_username','1'));
        $is_catch_all = count($validEmails->where('is_catch_all', '1'));
        $is_role = count($validEmails->where('is_role', '1'));
        $safe = $is_valid_email - ($is_catch_all + $is_role);

        $invalid = $total - $is_valid_email;
        array_push($overviews, ['category' => 'Safe', 'value' => $safe]);
        array_push($overviews, ['category' => 'Disposable', 'value' => $is_disposable]);
        array_push($overviews, ['category' => 'Catch All', 'value' => $is_catch_all]);
        array_push($overviews, ['category' => 'Role', 'value' => $is_role]);
        array_push($overviews, ['category' => 'Invalid', 'value' => $invalid]);


// Get the date 30 days ago
        $startDate = Carbon::now()->subDays(30);

// Get the current date and time
        $endDate = Carbon::now();

        $dates = [];
        for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }

        $records = ValidEmail::where('user_id', auth()->id())->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, count(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->map(function ($item) {
                return $item->total;
            });

        foreach ($dates as $date) {
            if (!isset($records[$date])) {
                $records[$date] = 0;
            }
        }

        $dateWiseEmailCheck = $records->sortBy(function ($value, $key) {
            return $key;
        })->map(function ($value, $key) {
            return [
                'date' => $key,
                'value' => $value
            ];
        })->values();

        return view('customer.overview', compact('overviews', 'dateWiseEmailCheck', 'total'));


    }

    public function test($email)
    {
        $emailVerify = new EmailVerifier();
        $result = $emailVerify->verify($email);
        $data = [
            'message' => $result['success'] === true ? "VALID" : "INVALID",
            'details' => [
                'email' => $email,
                'status' => $result['success'] === true ? "VALID" : "INVALID",
                'is_syntax_check' => $result['is_syntax_check']['status'] === true ? 'TRUE' : 'FALSE',
                'is_disposable' => $result['is_disposable']['status'] === true ? 'TRUE' : 'FALSE',
                'is_free_email' => $result['is_free_email']['status'] === true ? 'TRUE' : 'FALSE',
                'is_domain_found' => $result['is_domain']['status'] === true ? 'TRUE' : 'FALSE',
                'mx_accepts_mail' => $result['is_mx_record']['status'] === true ? 'TRUE' : 'FALSE',
                'mx_records' => $result['mx_record'],
                'can_connect_smtp' => $result['is_smtp_valid']['status'] === true ? 'TRUE' : 'FALSE',
                'is_username' => $result['is_username']['status'] === true ? 'TRUE' : 'FALSE',
                'is_catch_all' => $result['is_catch_all']['status'] === true ? 'TRUE' : 'FALSE',
                'is_role' => $result['is_role']['status'] === true ? 'TRUE' : 'FALSE',
                'process_time' => $result['process_time'],
                'email_score' => $result['email_score']
            ]
        ];
        $this->singleDataSave($result, $email, 'dashboard');
    }

    public function singleVerify(Request $request)
    {
        $email = $request->input('email');
        // sleep(3);
        $emailVerify = new EmailVerifier();
        $result = $emailVerify->verify($email);
        $this->emailDataSave($result, $email, 'dashboard');
        $data = [
            'message' => $result['success'] === true ? "VALID" : "INVALID",
            'details' => [
                'email' => $email,
                'status' => $result['success'] === true ? "VALID" : "INVALID",
                'is_syntax_check' => $result['is_syntax_check']['status'] === true ? 'TRUE' : 'FALSE',
                'is_disposable' => $result['is_disposable']['status'] === true ? 'TRUE' : 'FALSE',
                'is_free_email' => $result['is_free_email']['status'] === true ? 'TRUE' : 'FALSE',
                'is_domain_found' => $result['is_domain']['status'] === true ? 'TRUE' : 'FALSE',
                'mx_accepts_mail' => $result['is_mx_record']['status'] === true ? 'TRUE' : 'FALSE',
                'mx_records' => $result['mx_record'],
                'can_connect_smtp' => $result['is_smtp_valid']['status'] === true ? 'TRUE' : 'FALSE',
                'is_username' => $result['is_username']['status'] === true ? 'TRUE' : 'FALSE',
                'is_catch_all' => $result['is_catch_all']['status'] === true ? 'TRUE' : 'FALSE',
                'is_role' => $result['is_role']['status'] === true ? 'TRUE' : 'FALSE',
                'process_time' => $result['process_time'],
                'email_score' => $result['email_score']
            ]
        ];

        return $data;
    }

    function emailDataSave($result, $email, $where_to_check)
    {

        $data['email'] = $email;
        $data['where_to_check'] = $where_to_check;
        $data['is_syntax_check'] = $result['is_syntax_check']['status'] === true ? '0' : '1';
        $data['is_disposable'] = $result['is_disposable']['status'] === true ? '0' : '1';
        $data['->is_free_email'] = $result['is_free_email']['status'] === false ? '0' : '1';
        $data['is_domain'] = $result['is_domain']['status'] === true ? '0' : '1';
        $data['is_mx_record'] = $result['is_mx_record']['status'] === true ? '0' : '1';
        $data['is_smtp_valid'] = $result['is_smtp_valid']['status'] === true ? '0' : '1';
        $data['is_username'] = $result['is_username']['status'] === true ? '0' : '1';
        $data['is_catch_all'] = $result['is_catch_all']['status'] === false ? '0' : '1';
        $data['is_role'] = $result['is_role']['status'] === false ? '0' : '1';
        $data['process_time'] = $result['process_time'];
        $data['email_score'] = $result['email_score'];
        $data['user_id'] = auth()->id();
        $data['created_by_id'] = auth()->id();
        if ($result['success'] !== true) {
            $data['is_valid_email'] = '2';
        } else {
            $data['is_valid_email'] = '1';
            if ($result['is_catch_all']['status'] !== false) {
                $data['is_valid_email'] = '3';
            }
        }
        ValidEmail::create($data);
    }

    public function bulkVerification()
    {
        return view('customer.bulk-verification');
    }

    public function taskBulkVerification(Request $request)
    {

    }
}

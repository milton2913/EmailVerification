<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Controller;
use App\Models\ValidEmail;
use Illuminate\Http\Request;
use App\Services\EmailVerifier;
//use Exception;
use Illuminate\Support\Facades\Validator;
use ElliotJReed\DisposableEmail\Email;
use ElliotJReed\DisposableEmail\DisposableEmail;
use App\Jobs\VerifyValidEmailJob;
use DB;
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
use App\Services\VerifyEmail;
class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function newJobs()
    {
        $userId = auth()->id();

        $validEmails = ValidEmail::where('user_id', $userId)
            ->where('is_valid_email', '0')
            ->get();
        foreach ($validEmails as $validEmail) {
            dispatch(new VerifyValidEmailJob($validEmail));
        }
        // return redirect()->back()->with('success', 'Valid emails updated successfully.');
    }

public function emailVerifyForm(Request $request){
$email = trim($request->input('email'));
    $data = $request->validate([
        'email' => 'required|email'
    ]);
$result  = $this->checkEmailAddress($email);

return $result['is_disposable']['status'];

    $is_syntax_check = $result['is_syntax_check']['status']===true?'False':'True';
    $is_disposable = $result['is_disposable']['status']===true?'False':'True';
    $is_free_email = $result['is_free_email']['status']===false?'False':'True';
    $is_domain = $result['is_domain']['status']===true?'False':'True';
    $is_mx_record = $result['is_mx_record']['status']===true?'False':'True';
    $is_smtp_valid = $result['is_smtp_valid']['status']===true?'False':'True';
    $is_username = $result['is_username']['status']===true?'False':'True';
    $is_catch_all = $result['is_catch_all']['status']===false?'False':'True';
    $is_role = $result['is_role']['status']===false?'False':'True';
    $process_time = $result['process_time'];
    $email_score = $result['email_score'];
        $data = "<h6 class='sub_heading mt_10'>Email Address: $email</h6>
                        <p class='text_14 mb_15'>Valid Format: <span class='text_white text_semibold'>$is_syntax_check</span></p>
                        <p class='text_14 student_name mb_15'><span>Domain: </span><span class='text_white text_semibold'>$is_domain</span></p>
                        <p class='text_14 student_name mb_15'><span>SMTP: </span><span class='text_white text_semibold'>$is_smtp_valid</span></p>
                        <p class='text_14 mb_15'>MX-Records: <span class='text_white text_semibold'>$is_mx_record</span></p>
                        <p class='text_14 mb_15'>Usernaem: <span class='text_white text_semibold'>$is_username</span></p>
                        <p class='text_14 mb_15'>Catch-All: <span class='text_white text_semibold'>$is_catch_all</span></p>
                        <p class='text_14 mb_15'>Role: <span class='text_white text_semibold'>$is_role</span></p>
                        <p class='text_14 mb_15'>Disposable: <span class='text_white text_semibold'>$is_disposable</span></p>
                        <p class='text_14 mb_15'>Process Time: <span class='text_white text_semibold'>$process_time</span></p>
                        <p class='text_14 mb_15'>Email Score: <span class='text_white text_semibold'>$email_score</span></p>
                        <p class='text_14 mb_15'>Free: <span class='text_white text_semibold'>$is_free_email</span></p>";
    return response()->json(['success'=>$data]);

}


    public function verify()
    {
        $email = "milton2913@gmail.com";
        $email = trim($email);
        $start = hrtime(true);
        $result = $this->checkEmailAddress3($email);
//        $result = $this->checkEmailAddress($email);
        $end = hrtime(true); // End time in nanoseconds
        $elapsed = (($end - $start) / 1e6)/1000; // Processing time in milliseconds
        $result['process_time'] = "$elapsed second";
        return $result;
    }

    public function checkEmailAddress3($email)
    {

        $data = [
            'success' => false,
            'message' => 'Unknown error',
            'process_time' => 0,
            'email_score' => 0,
            'mx_record' => '',
            'is_syntax_check' => [
                "status" => false,
                "message" => "False"
            ],
            'is_disposable' => [
                "status" => true,
                "message" => "true"
            ],
            'is_free_email' => [
                "status" => false,
                "message" => "False"
            ],
            'is_domain' => [
                "status" => false,
                "message" => "False"
            ],
            'is_mx_record' => [
                "status" => false,
                "message" => "False"
            ],
            'is_smtp_valid' => [
                "status" => false,
                "message" => "False"
            ],
            'is_username' => [
                "status" => false,
                "message" => "False"
            ],

            'is_catch_all' => [
                "status" => false,
                "message" => "It's not a catch all email address"
            ],
            'is_role' => [
                "status" => false,
                "message" => "It's not a role based email address"
            ],
        ];

        if ($this->checkSyntax($email) === true) {
            $domain = explode('@', $email)[1];
            $data['is_syntax_check']['status'] = true;
            $data['is_syntax_check']['message'] = "Valid Email Syntax";
            if ($this->checkDisposable($email) === true) {
                $data['is_disposable']['status'] = true;
                $data['is_disposable']['message'] = "This is a disposable / temporary email address";
                //check free domain
            } else {
                $data['is_disposable']['status'] = false;
                $data['is_disposable']['message'] = "This is not a disposable / temporary email address";
                if ($this->checkFreeEmail($email, $domain) === true) {
                    $data['is_free_email']['status'] = true;
                    $data['is_free_email']['message'] = "It's a free email address";
                } else {
                    $data['is_free_email']['status'] = false;
                    $data['is_free_email']['message'] = "It's not a free email address";
                }
                if ($this->checkIsRole($email) === true) {
                    $data['is_role']['status'] = true;
                    $data['is_role']['message'] = "It's a role based email address";
                }
//check dns
                if ($this->checkDns($domain) === null) {
                    $data['is_domain']['status'] = true;
                    $data['is_domain']['message'] = 'Checking domain: Domain is exist';
                    $mx_records = $this->getMxRecord($domain);
                    $count = 0;
                    if ($mx_records !== false) {
                        $data['is_mx_record']['status'] = true;
                        $data['is_mx_record']['message'] = 'MX record is found';


                        foreach ($mx_records as $mx_record) {
                            if (!empty($mx_record)) {
                                if ($this->telNetConnection($mx_record, 25) === true) {
                                    $data['mx_record'] = $mx_record;
                                    $data['is_smtp_valid']['status'] = true;
                                    $data['is_smtp_valid']['message'] = 'SMTP connect';
                                    $result = $this->checkUsername($domain, $mx_record, 25, $email);
                                    if ($result['is_username']['status'] === true) {
                                        $data['is_username']['status'] = true;
                                        $data['is_username']['message'] = 'Username is Valid';
                                        if ($result['is_catch_all']['status'] == true) {
                                            $data['is_catch_all']['status'] = true;
                                            $data['is_catch_all']['message'] = 'Catch-All';
                                        }
                                        break; //if 1st mx record found email address then close foreach loop
                                    } else {
                                        $data['is_username']['status'] = false;
                                        $data['is_username']['message'] = 'Username is not Valid';
                                        break; //if 1st mx record email address is not  found then invalid and close// if when multiple mx record check then break statement comment out here
                                    }

                                } else {
                                    $data['is_smtp_valid']['status'] = false;
                                    $data['is_smtp_valid']['message'] = 'SMTP is not connected!';
                                }
                            }else{
                                $data['is_mx_record']['status'] = false;
                                $data['is_mx_record']['message'] = 'MX record is not found';
                                break;
                            }
                        }
                    } else {
                        $data['is_mx_record']['status'] = false;
                        $data['is_mx_record']['message'] = 'MX record is not found';
                    }
                }
            }
        } else {
            $data['is_syntax_check']['status'] = false;
            $data['is_syntax_check']['message'] = "Invalid Email Syntax";
        }

        foreach ($data as $key => $item) {
            if (is_array($item) === true) {
                if ($key !== "is_free_email" && $key !== "is_disposable" && $key !== "is_catch_all" && $key !== "is_role") {
                    if ($item['status'] === true) {
                        $data['success'] = true;
                        $data['message'] = "Email is valid";
                    } else {
                        $data['success'] = false;
                        $data['message'] = "Email is not valid";
                        break;
                    }
                }
            }
        }
        $data = $this->emailScore($data);
        return $data;
    }

    public function checkEmailAddress($email)
    {
        $data = [
            'success' => false,
            'message' => 'Unknown error',
            'process_time' => 0,
            'email_score' => 0,
            'is_syntax_check' => [
                "status" => false,
                "message" => "False"
            ],
            'is_disposable' => [
                "status" => true,
                "message" => "true"
            ],
            'is_free_email' => [
                "status" => false,
                "message" => "False"
            ],
            'is_domain' => [
                "status" => false,
                "message" => "False"
            ],
            'is_mx_record' => [
                "status" => false,
                "message" => "False"
            ],
            'is_smtp_valid' => [
                "status" => false,
                "message" => "False"
            ],
            'is_username' => [
                "status" => false,
                "message" => "False"
            ],

            'is_catch_all' => [
                "status" => false,
                "message" => "It's not a catch all email address"
            ],
            'is_role' => [
                "status" => false,
                "message" => "It's not a role based email address"
            ],
        ];


        $domain = explode('@', $email)[1];

        if ($this->checkSyntax($email) === true) {
            $data['is_syntax_check']['status'] = true;
            $data['is_syntax_check']['message'] = "Valid Email Syntax";
        } else {
            $data['is_syntax_check']['status'] = false;
            $data['is_syntax_check']['message'] = "Invalid Email Syntax";
        }
        if ($this->checkDisposable($email) === true) {
            $data['is_disposable']['status'] = false;
            $data['is_disposable']['message'] = "This is a disposable / temporary email address";
        } else {
            $data['is_disposable']['status'] = true;
            $data['is_disposable']['message'] = "This is not a disposable / temporary email address";
        }

        if ($this->checkFreeEmail($email, $domain) === true) {
            $data['is_free_email']['status'] = true;
            $data['is_free_email']['message'] = "It's a free email address";
        } else {
            $data['is_free_email']['status'] = false;
            $data['is_free_email']['message'] = "It's not a free email address";
        }
        if ($this->checkIsRole($email) === true) {
            $data['is_role']['status'] = true;
            $data['is_role']['message'] = "It's a role based email address";
        }
        if ($this->checkDns($domain) === null) {
            $data['is_domain']['status'] = true;
            $data['is_domain']['message'] = 'Checking domain: Domain is exist';
        }
        $mx_records = $this->getMxRecord($domain);

        if ($mx_records !== false) {

            $data['is_mx_record']['status'] = true;
            $data['is_mx_record']['message'] = 'MX record is found';

            foreach ($mx_records as $mx_record) {
                if (!empty($mx_record)) {
                    if ($this->telNetConnection($mx_record, 25) === true) {
                        $data['is_smtp_valid']['status'] = true;
                        $data['is_smtp_valid']['message'] = 'SMTP connect';
                        $result = $this->checkUsername($domain, $mx_record, 25, $email);
                        if ($result['is_username']['status'] === true) {
                            $data['is_username']['status'] = true;
                            $data['is_username']['message'] = 'Username is Valid';
                            if ($result['is_catch_all']['status'] == true) {
                                $data['is_catch_all']['status'] = true;
                                $data['is_catch_all']['message'] = 'Catch-All';
                            }
                            break; //if 1st mx record found email address then close foreach loop
                        } else {
                            $data['is_username']['status'] = false;
                            $data['is_username']['message'] = 'Username is not Valid';
                            break; //if 1st mx record email address is not  found then invalid and close// if when multiple mx record check then break statement comment out here
                        }

                    } else {
                        $data['is_smtp_valid']['status'] = false;
                        $data['is_smtp_valid']['message'] = 'SMTP is not connected!';
                    }
                }else{
                    $data['is_mx_record']['status'] = false;
                    $data['is_mx_record']['message'] = 'MX record is not found';
                    break;
                }
            }
        } else {
            $data['is_mx_record']['status'] = false;
            $data['is_mx_record']['message'] = 'MX record is not found';
        }


        foreach ($data as $key => $item) {
            if (is_array($item) === true) {
                if ($key !== "is_free_email" && $key !== "is_catch_all" && $key !== "is_role") {
                    if ($item['status'] === true) {
                        $data['success'] = true;
                        $data['message'] = "Email is valid";
                    } else {
                        $data['success'] = false;
                        $data['message'] = "Email is not valid";
                        break;
                    }
                }
            }
        }
        $data = $this->emailScore($data);
        return $data;
    }

    public function checkSyntax($email)
    {
        $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
        if ($validator->fails()) {
            return false;
        } else {
            return true;
        }
        return $data;
    }

    public function checkDisposable($email)
    {
        if (DisposableEmail::isDisposable($email)) {
            return true;
        } else {
            return false;
        }
    }

    function checkFreeEmail($email, $domain)
    {
        $freEmailProviders = array(
            "gmail.com",
            "yahoo.com",
            "outlook.com",
            "aol.com",
            "zoho.com",
            "protonmail.com",
            "gmx.com",
            "mail.com",
            "tutanota.com",
            "yandex.com"
        );

        if (in_array($domain, $freEmailProviders)) {
            return true;
        } else {
            return false;
        }
    }

    function checkIsRole($email)
    {
        $username =  explode('@', $email)[0];
        $email_usernames = array(
            'admin',
            'billing',
            'contact',
            'helpdesk',
            'info',
            'marketing',
            'sales',
            'support',
            'webmaster',
            'abuse',
            'noc',
            'postmaster',
            'security',
            'spam',
            'subscribe',
            'unsubscribe',
            'hr',
            'jobs',
            'press',
            'media',
            'feedback',
            'customer_service',
            'customerservice',
            'info_request',
            'media_request',
            'public_relations',
            'tech_support',
            'web_support'
        );
        if (in_array($username, $email_usernames)) {
            return true;
        } else {
            return false;
        }
    }


    function checkDns($domain)
    {
        //        // Domain Verification
        try {
            $mxhosts = [];
            if (!checkdnsrr($domain, 'MX') || !getmxrr($domain, $mxhosts)) {
                $result['is_domain']['status'] = 'error';
                $result['is_domain']['message'] = 'Invalid email address: domain does not exist.';
                return $result;
            }
        } catch (Exception $e) {
            $result['is_domain']['status'] = 'error';
            $result['is_domain']['message'] = 'Error checking domain: ' . $e->getMessage();
            return $result;
        }
    }

    public function getMxRecord($domain)
    {
        $mx_records = [];
        if (getmxrr($domain, $mx_records)) {
            $mx_records = $this->mxRecordShortAndFilter($mx_records);
            return $mx_records;
        } else {
            return false;
        }
    }


    public function telNetConnection($hostname, $port)
    {
        $command = "echo '' | telnet $hostname $port 2>/dev/null | grep 'Escape character'";
        $output = exec($command, $telnetOutput, $returnVal);
        if ($returnVal == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUsername($hostname, $smtpServer, $smtpPort, $username)
    {

// Connect to the SMTP server
        $smtpSocket = fsockopen($smtpServer, $smtpPort, $errno, $errstr, 10);
        if (!$smtpSocket) {
            // Connection failed
            echo "Error: $errstr ($errno)\n";
        } else {
            if ($hostname == "yahoo.com" || $hostname == "hotmail.com") {
                $response = fgets($smtpSocket, 1024);
//    // Send the test email to the specified email address
                fwrite($smtpSocket, "EHLO $smtpServer\r\n");
                $response = fgets($smtpSocket, 1024);

                fwrite($smtpSocket, "MAIL FROM: $smtpServer\r\n");
                $response = fgets($smtpSocket, 1024);
                fwrite($smtpSocket, "RCPT TO: <$username>\r\n");
                $response = fgets($smtpSocket, 1024);

            } else {
                $response = fgets($smtpSocket, 515);
                // Send HELO command
                fwrite($smtpSocket, "HELO $smtpServer\r\n");
                $response = fgets($smtpSocket, 515);
                // Send MAIL FROM command
                fwrite($smtpSocket, "MAIL FROM: <$username>\r\n");
                $response = fgets($smtpSocket, 515);
                // Send RCPT TO command for the username we want to check
                fwrite($smtpSocket, "RCPT TO: <$username>\r\n");
                $response = fgets($smtpSocket, 515);
            }
            // Check the response from the RCPT TO command
            if (substr($response, 0, 3) == '250') {
                $data['is_username']['status'] = true;
                fwrite($smtpSocket, "RCPT TO: <catchallemailcheckforthisdomain@$hostname>\r\n");
                $responseCatchAll = fgets($smtpSocket, 1024);
                if (substr($responseCatchAll, 0, 3) == '250') {
                    $data['is_catch_all']['status'] = true;
                }else{
                    $data['is_catch_all']['status'] = false;
                }
            }else {
                $data['is_username']['status'] = false;
            }
            fwrite($smtpSocket, "QUIT\r\n");
            fclose($smtpSocket);
            return  $data;
        }
    }

    function mxRecordShortAndFilter($mx_records){
        // custom sorting algorithm
        usort($mx_records, function ($a, $b) {
            // if both strings contain "google.com", sort alphabetically
            if (strpos($a, "google.com") !== false && strpos($b, "google.com") !== false) {
                return strcmp($a, $b);
            }
            // if $a contains "google.com", sort it after $b
            else if (strpos($a, "google.com") !== false) {
                return 1;
            }
            // if $b contains "google.com", sort it after $a
            else if (strpos($b, "google.com") !== false) {
                return -1;
            }
            // otherwise, sort alphabetically
            else {
                return strcmp($a, $b);
            }
        });
        return array_reverse($mx_records);
    }
    function emailScore($data){
        $score = 0;
        if ($data['is_syntax_check']['status']==true){
            $score +=0.25;
        }
        if ($data['is_domain']['status']==true){
            $score +=0.10;
        }
        if ($data['is_mx_record']['status']==true){
            $score +=0.10;
        }
        if ($data['is_smtp_valid']['status']==true){
            $score +=0.15;
        }
        if ($data['is_username']['status']==true){
            $score +=0.40;
        }
        if ($data['is_free_email']['status']==true){
            $score -=0.10;
        }
        if ($data['is_role']['status']==true){
            $score -=0.05;
        }
        if ($data['is_catch_all']['status']==true){
            $score -=0.35;
        }

        if ($data['is_disposable']['status']==true){
            $score -=0.30;
        }
        $data['email_score'] = $score;
        return $data;
    }

}

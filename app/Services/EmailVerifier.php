<?php

namespace App\Services;
use App\Models\ValidEmail;
use ElliotJReed\DisposableEmail\DisposableEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use DB;
class EmailVerifier
{

    public function emailVerify($validEmail){
        $result = $this->verify($validEmail->email);
        $validEmail->is_syntax_check = $result['is_syntax_check']['status']===true?'0':'1';
        $validEmail->is_disposable = $result['is_disposable']['status']===true?'0':'1';
        $validEmail->is_free_email = $result['is_free_email']['status']===false?'0':'1';
        $validEmail->is_domain = $result['is_domain']['status']===true?'0':'1';
        $validEmail->is_mx_record = $result['is_mx_record']['status']===true?'0':'1';
        $validEmail->is_smtp_valid = $result['is_smtp_valid']['status']===true?'0':'1';
        $validEmail->is_username = $result['is_username']['status']===true?'0':'1';
        $validEmail->is_catch_all = $result['is_catch_all']['status']===false?'0':'1';
        $validEmail->is_role = $result['is_role']['status']===false?'0':'1';
        $validEmail->process_time = $result['process_time'];
        $validEmail->email_score = $result['email_score'];
        if ($result['success']!==true){
            $validEmail->is_valid_email='2';
             if ($result['is_disposable']['status']!==true){
                $validEmail->is_valid_email='5';
            }
        }else{
            if ($result['is_catch_all']['status']!==false){
                $validEmail->is_valid_email='3';
            } else if ($result['is_role']['status']===true){
                $validEmail->is_valid_email='4';
            }else{
                $validEmail->is_valid_email='4';
            }
        }
    }

    public function verify($email)
    {
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

//        if ($data['is_syntax_check']['status']==true){
//            $data['email_score']=$data['email_score']+0.20;
//            if ($data['is_domain']['status']==true){
//                $data['email_score']=$data['email_score']+0.10;
//                if ($data['is_free_email']['status']==true){
//                    $data['email_score']=$data['email_score']-0.10;
//                }
//                if ($data['is_mx_record']['status']==true){
//                    $data['email_score']=$data['email_score']+0.10;
//                    if ($data['is_disposable']['status']==true){
//                        $data['email_score']=$data['email_score']-0.20;
//                    }
//                    if ($data['is_smtp_valid']['status']==true){
//                        $data['email_score']=$data['email_score']+0.20;
//                        if ($data['is_username']['status']==true){
//                            $data['email_score']=$data['email_score']+0.40;
//                        }
//                        if ($data['is_catch_all']['status']==true){
//                            $data['email_score']=$data['email_score']-0.36;
//                        }
//                        if ($data['is_role']['status']==true){
//                            $data['email_score']=$data['email_score']-0.10;
//                        }
//                    }
//                }
//            }
//        }
        $data['email_score'] = $score;
        return $data;
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Warning\SpoofEmail;
use GuzzleHttp\Client;
class TestController extends Controller
{
    public function index()
    {
        $validator = new EmailValidator();

        $email = 'milton2913@hotmail.com';

        if ($validator->isValid($email, new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
        ]))) {
            $domain = substr(strrchr($email, "@"), 1);
            $disposable_domains = ['domain1.com', 'domain2.com', '...']; // add your list of disposable domains
            if (in_array($domain, $disposable_domains)) {
                echo "This email is a disposable email";
            } elseif ($validator->hasWarnings() && $validator->getWarnings()[0] instanceof SpoofEmail) {
                echo "This email is a potential spoof";
            } elseif ($this->isSpam($email, $domain)) {
                echo "This email is a known spam trap";
            } else {
                echo "This email is valid";
            }
        } else {
            echo "This email is invalid";
        }

    }

    function isSpam($email, $domain) {

        $client = new Client(['base_uri' => 'https://www.spamhaus.org']);
        $response = $client->request('GET', '/dbl/check', [
            'query' => [
                'domain' => $domain,
                'email' => $email
            ]
        ]);

        $body = $response->getBody()->getContents();
        return strpos($body, 'LISTED') !== false;
    }
}

<?php
namespace App\Services;

class VerifyEmailException extends Exception {

    /**
     * Prettify error message output
     * @return string
     */
    public $errorMsg;
    public function __construct($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    public function errorMessage() {
        $errorMsg = $this->getMessage();
        return $errorMsg;
    }

}

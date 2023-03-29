<?php

namespace App\Observers;

use App\Models\Bulk;
use App\Models\ValidEmail;
use App\Services\EmailVerifier;
class ValidEmailObserver
{
    /**
     * Handle the ValidEmail "created" event.
     *
     * @param  \App\Models\ValidEmail  $validEmail
     * @return void
     */
    public function created(ValidEmail $validEmail)
    {

       $emailVerify = new EmailVerifier();
       $result = $emailVerify->verify($validEmail->email);
       if ($result['success']===true){
           $validEmail->is_valid_email = '1';
           $update = $validEmail->save();
       }else{
           $validEmail->is_valid_email = '2';
           $update = $validEmail->save();
       }
    }

    /**
     * Handle the ValidEmail "updated" event.
     *
     * @param  \App\Models\ValidEmail  $validEmail
     * @return void
     */
    public function updated(ValidEmail $validEmail)
    {

    }

    /**
     * Handle the ValidEmail "deleted" event.
     *
     * @param  \App\Models\ValidEmail  $validEmail
     * @return void
     */
    public function deleted(ValidEmail $validEmail)
    {
        //
    }

    /**
     * Handle the ValidEmail "restored" event.
     *
     * @param  \App\Models\ValidEmail  $validEmail
     * @return void
     */
    public function restored(ValidEmail $validEmail)
    {
        //
    }

    /**
     * Handle the ValidEmail "force deleted" event.
     *
     * @param  \App\Models\ValidEmail  $validEmail
     * @return void
     */
    public function forceDeleted(ValidEmail $validEmail)
    {
        //
    }
}

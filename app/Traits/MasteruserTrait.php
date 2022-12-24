<?php

namespace App\Traits;

use App\Models\User;

/**
 *
 */
trait MasteruserTrait
{
    public $masterUser;

    public function bootMasteruserTrait()
    {
        $this->masterUser = User::whereNull('upline_id')->first();
    }
}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class LegacyLogin extends Authenticatable
{
    /**
     * Table name where the legacy user accounts can be found
     *
     * @var string
     */
    protected $table = 'legacy_logins';
}

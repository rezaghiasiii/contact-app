<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;

class ContactSearchScope extends SearchScope
{
    protected $searchColumns = ['first_name', 'last_name', 'email', 'company.name'];
}

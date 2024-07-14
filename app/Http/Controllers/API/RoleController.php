<?php

namespace App\Http\Controllers\API;

use App\Models\Role;

class RoleController extends BaseCrudController
{
    public function __construct()
    {
        parent::__construct('Role', Role::class, Role::validations());
    }
}

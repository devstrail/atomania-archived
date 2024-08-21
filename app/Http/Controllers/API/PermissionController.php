<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;

class PermissionController extends BaseCrudController
{
    public function __construct()
    {
        parent::__construct("Permission", Permission::class, Permission::validations());
    }
}

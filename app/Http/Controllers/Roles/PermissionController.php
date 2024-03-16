<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
   function index(){}

    function store(Request $request)
    {
        $permission = Permission::create(['name' => 'moderate comment']);

        return new ApiSuccessResponse($permission,['message' => 'permission created successfully!'],201);

    }
}

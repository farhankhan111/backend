<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => 'comment']);

        return new ApiSuccessResponse($role,['message' => 'role created successfully!'],201);
    }

    public function assignRole(Request $request){

         $user = User::findOrFail($request->user_id);

         $user->assignRole($request->role);

        return new ApiSuccessResponse($user,['message' => 'role assign successfully!'],201);
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangeUserRoleRequest;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Data Retrieved', 'data' =>$this->transformObject(User::all(), new UserTransformer())]);
    }

    public function addUser(AddUserRequest $request)
    {
        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

        $user->assignRole($request->role);

        return response()->json(['message' => 'User created successfully']);
    }

    public function changeRole(ChangeUserRoleRequest $request)
    {

        $user = User::findOrFail($request->user_id);

        $user->syncRoles($request->role);

        return response()->json(['message' => 'User role changed successfully', 'data' => $this->transformObject($user, new UserTransformer())]);
    }
}

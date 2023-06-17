<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(User $user)
    {
        return response()->json(UserResource::collection($user->with("roles")->orderBy('id', 'desc')->get()));
    }

    public function customer_options(User $user)
    {
        return response()->json($user->all(['id', 'name']));
    }

    public function store(Request $request, User $user)
    {
        $role = Role::find($request->role_id);

        $newUser = $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        $newUser->assignRole($role->name);

        return response()->json($user);
    }

    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    public function update(Request $request, User $user)
    {
        if($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        if(isset($request->role_id)){
            if(count($user->roles) > 0){
                $role = $user->roles->first();
                $user->removeRole($role);
            }
            $newRole = Role::find($request->role_id);
            $user->assignRole($newRole->name);
        }

        return response()->json(UserResource::collection($user->with("roles")->get()));

    }

    public function destroy(User $user)
    {
        $user->delete();
    }

    public function user_options(User $user){
        return response()->json($user->all(['id', 'name']));
    }
}

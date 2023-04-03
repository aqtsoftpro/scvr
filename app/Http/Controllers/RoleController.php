<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Role $role){
        return response()->json($role->orderBy('id', 'desc')->get());
    }

    public function show(Role $role){
        return response()->json($role->find($role->id));
    }

    public function store(Request $request, Role $role){
        $newRole = $role->create($request->all());
        $res = [
            'message' => 'Role record created',
            'data' => $newRole
        ];
        return response()->json($res);
    }

    public function update(Request $request, Role $role){
        $role->fill($request->all());
        $role->save();
        $res = [
            'message' => 'Role record updated',
            'data' => $role
        ];
        return response()->json($res);
    }

    public function destroy(Role $role){
        $role->delete();
        $res = [
            'message' => 'Role record deleted',
        ];
    }

    public function role_options(){
        $roles = Role::all(['id', 'name']);
        return response()->json($roles);
    }

}

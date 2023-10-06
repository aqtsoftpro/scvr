<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Permission $permission){
        return response()->json($permission->orderBy('id', 'desc')->get());
    }

    public function show(Permission $permission){
        return response()->json($permission->find($permission->id));
    }

    public function store(Request $request, Permission $permission){
        $newPermission = $permission->create($request->all());
        $res = [
            'message' => 'Permission record created',
            'data' => $newPermission
        ];
        return response()->json($res);
    }

    public function update(Request $request, Permission $permission){
        $permission->fill($request->all());
        $permission->save();
        $res = [
            'message' => 'Permission record updated',
            'data' => $permission
        ];
        return response()->json($res);
    }

    public function destroy(Permission $permission){
        $permission->delete();
        $res = [
            'message' => 'Permission record deleted',
        ];
    }
}

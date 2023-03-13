<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(User $user)
    {
        return $user->all();
    }

    public function store(Request $request, User $user)
    {
        $user->create($request->all());
        return $user;
    }

    public function show(User $user, int $id)
    {
        return $user->find($id);
    }

    public function update(Request $request, User $user, int $id)
    {
        $user->find($id)->update($request->all());
        return $user;
    }

    public function destroy(User $user, int $id)
    {
        $user->find($id)->delete();

    }
}

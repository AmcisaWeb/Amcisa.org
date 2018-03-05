<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller{


    public function getRole()
    {
        $role = Role::all();
        $response = [
            'role' => $role
        ];
        return response()->json($response, 200);
    }

    public function postRole(Request $request)
    {
        //$q = 'DELETE * FROM roles';
        $roles = Role::all();
        foreach ($roles as $i)
        {
            $i->delete();
        }
        $admin = new Role();
        $admin->user_id = 1; //admin has id 1
        $admin->role = 'admin';
        $admin->save();

        $req = json_decode($request);

        return $req;
        foreach ($req as $i)
        {
            return $i->user_id;
        }

        return response()->json("asd", 200);
    }
}
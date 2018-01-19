<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests;

class RolePermissionController extends Controller
{
    public function update(Request $request,$roleName){
      try{
         $role=Role::findByName($roleName);
         $role->permissions()->detach(); //delete all previous perms
          foreach ($request->names as $name){ //user should sent array of permision Name to be assign to role
              $role=Role::findByName($roleName);
             $role->givePermissionTo($name);

          }
          return  array("successful"=>true, "message"=>"permission was created/updated");
      }
      catch (\Exception $e){
          return $e;
          return response()->Json(['message' => 'role not found/permission '], 404);
      }
    }

    public function getAllPermission(){
        return Permission::all();
    }

    public function getThisRolePermission($roleName){
        $role=Role::findByName($roleName);
        return $role->permissions()->get();
    }

}

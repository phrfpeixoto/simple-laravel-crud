<?php

namespace App\Http\Controllers;

use App\History;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('permissions')->get();
        return compact('users');
    }

    public function changePermission($user, $permission_string, $change){
        $permission = Permission::where('permission', $permission_string)->first();

        if(!$permission){
            return response()->json(['message' => trans("Unknown permission {$permission_string}")])->setStatusCode(404, 'Error');
        }

        try{
            DB::transaction(function() use ($user, $permission, $permission_string, $change) {
                $logged_user_name = auth()->user()->name;

                if($change === 'authorize'){
                    $entry = trans("User {$logged_user_name} granted permission '{$permission_string}' to user '{$user->name}'(ID {$user->id})");
                    $user->permissions()->attach($permission);
                }
                else{
                    $entry = trans("User {$logged_user_name} revoked permission '{$permission_string}' from user '{$user->name}'(ID {$user->id})");
                    $user->permissions()->detach($permission);
                }
                $user->save();

                History::create(['entry'=>$entry]);
            });
            $user = User::with('permissions')->find($user->id);
            return compact('user');
        }
        catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()])->setStatusCode(500, 'Error');
        }
    }

    public function authorizeUser(Request $request, User $user){
        $permission_string = $request->get('permission');
        return $this->changePermission($user, $permission_string, 'authorize');
    }

    public function unauthorizeUser(Request $request, User $user){
        $permission_string = $request->get('permission');
        return $this->changePermission($user, $permission_string, 'unauthorize');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

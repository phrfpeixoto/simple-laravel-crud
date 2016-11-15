<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_user')->delete();
        DB::table('permissions')->delete();
        Permission::create(['permission' => 'admin']);
        Permission::create(['permission' => 'manage-states']);
        Permission::create(['permission' => 'audit']);
    }
}

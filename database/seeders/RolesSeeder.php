<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'developer']);
        Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'member']);
        Role::firstOrCreate(['name' => 'receptionist']);

        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'view roles']);
        Permission::firstOrCreate(['name' => 'assign roles']);
        Permission::firstOrCreate(['name' => 'revoke roles']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'view users password']);
        
        $role = Role::findByName('admin');
        $role->givePermissionTo('view roles');
        $role->givePermissionTo('assign roles');
        $role->givePermissionTo('revoke roles');
        $role->givePermissionTo('manage permissions');
        $role->givePermissionTo('edit users');
        $role->givePermissionTo('delete users');
        $role->givePermissionTo('create users');
        $role->givePermissionTo('view users');  
        $role->givePermissionTo('view users password');  


        $role2 = Role::findByName('member');
        $role2->givePermissionTo('view users');

        $user = User::find(1);
        $user->assignRole('admin');

        $user2 = User::find(2);
        $user2->assignRole('member');
    }
}

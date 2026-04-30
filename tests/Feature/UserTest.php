<?php
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\{get, post, put, delete, assertDatabaseHas, assertDatabaseMissing, actingAs};

beforeEach(function () {
    $permission1 = Permission::create(['name' => 'view users']);
    $permission2 = Permission::create(['name' => 'create users']);
    $permission3 = Permission::create(['name' => 'edit users']);  
    $permission4 = Permission::create(['name' => 'delete users']);
    $user = User::factory()->create();
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission1);
    $role->givePermissionTo($permission2);
    $role->givePermissionTo($permission3);
    $role->givePermissionTo($permission4);
    $user->assignRole($role);

    actingAs($user);
});
test('Can create a user with role', function () {
    $role = Role::create(['name' => 'member']);
    $response = post(route('user.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
        'roles' => $role->name
    ]);

    $response->assertRedirect(route('user.index'));

    assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    $user = actingAs(User::factory()->create())->get(route('user.index'));
    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->hasRole($role->name))->toBeTrue();
});

test('Can update a user and change role', function () {
    $role1 = Role::create(['name' => 'editor']);
    $role2 = Role::create(['name' => 'receptionist']);
    
    $user = User::factory()->create([
        'password' => bcrypt('oldpassword'),
    ]);

    $user->assignRole($role1);

    $response = put(route('user.update', $user), [
        'name' => 'Update Jane Doe',
        'email' => 'updated@example.com',
        'password' => 'newpassword',
        'roles' => $role2->name
    ]);
    $response->assertRedirect(route('user.index'));

    assertDatabaseHas('users', [
        'name' => 'Update Jane Doe',
        'email' => 'updated@example.com'
    ]);
    expect($user->fresh()->hasRole($role2->name))->toBeTrue();
});

test('Can delete a user', function () {
    $user = User::factory()->create();
    $response = get(route('user.delete', $user->id));
    $response->assertRedirect(route('user.index'));

    assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});
// test('use the testing environment', function () {
//     dump([
//         'app_env_helper' => app()->environment(),
//         'env_var' => env('APP_ENV'),
//         'env_config' => config('app.env'),]);
// });
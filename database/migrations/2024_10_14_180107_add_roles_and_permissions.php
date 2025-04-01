<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $support = Role::create(['name' => 'support']);
        $technician = Role::create(['name' => 'technician']);

        Permission::create(['name' => 'view admin panel']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'add users']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo('view admin panel', 'edit users', 'delete users', 'add users');
        $support->givePermissionTo('edit users');
        $technician->givePermissionTo('view admin panel', 'edit users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'view admin panel')->delete();
        Permission::where('name', 'edit users')->delete();
        Permission::where('name', 'delete users')->delete();
        Permission::where('name', 'add users')->delete();

        Role::where('name', 'super-admin')->delete();
        Role::where('name', 'admin')->delete();
        Role::where('name', 'support')->delete();
        Role::where('name', 'technician')->delete();
    }
};

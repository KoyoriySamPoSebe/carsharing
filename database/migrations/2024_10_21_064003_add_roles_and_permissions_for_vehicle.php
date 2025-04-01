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
        $newPermissions = [
            'view_vehicles_panel',
            'view_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'add_vehicles',
        ];

        foreach ($newPermissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $superAdmin = Role::where('name', 'super-admin')->first();
        $admin = Role::where('name', 'admin')->first();
        $technician = Role::where('name', 'technician')->first();
        $support = Role::where('name', 'support')->first();

        if ($superAdmin) {
            $superAdmin->givePermissionTo($newPermissions);
        }

        if ($admin) {
            $admin->givePermissionTo($newPermissions);
        }

        if ($technician) {
            $technician->givePermissionTo('view_vehicles');
        }

        if ($support) {
            $support->givePermissionTo('edit_vehicles');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissionsToDelete = [
            'view_vehicles_panel',
            'view_vehicles',
            'edit_vehicles',
            'delete_vehicles',
            'add_vehicles',
        ];

        foreach ($permissionsToDelete as $permissionName) {
            Permission::where('name', $permissionName)->delete();
        }
    }
};

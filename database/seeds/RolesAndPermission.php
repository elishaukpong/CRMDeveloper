<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $writerRole = Role::create(['name' => 'Writer']);
        $viewerRole = Role::create(['name' => 'Viewer']);

        $writerRole->syncPermissions([
            Permission::create(['name' => 'create articles']),
            Permission::create(['name' => 'edit articles']),
            Permission::create(['name' => 'delete articles'])
        ]);

        $viewerRole->syncPermissions([
            Permission::create(['name' => 'view articles']),
            Permission::create(['name' => 'like articles']),
            Permission::create(['name' => 'comment on articles'])
        ]);

        $adminRole->syncPermissions(Permission::all());
    }
}

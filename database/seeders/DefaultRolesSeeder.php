<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Cria a role gestor_cv
        $gestorRole = Role::firstOrCreate(['name' => 'gestor_cv']);

        $createPermission = Permission::firstOrCreate(['name' => 'criar_curriculum']);
        $viewPermission = Permission::firstOrCreate(['name' => 'visualizar_curriculum']);

        $gestorRole->syncPermissions([$createPermission, $viewPermission]);

        // Recupera a role super_admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo('visualizar_qualquer_curriculum');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

class CreateSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cria ou obtém a role "super_admin"
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // 2. Coleta todas as permissões do Filament (baseadas nos Resources)
        $permissions = [];

        foreach (Filament::getResources() as $resource) {
            $model = $resource::getModel();
            $modelName = Str::snake(class_basename($model), '-');

            // Permissões CRUD padrão por recurso
            $permissions[] = "view_{$modelName}";
            $permissions[] = "view_any_{$modelName}";
            $permissions[] = "create_{$modelName}";
            $permissions[] = "update_{$modelName}";
            $permissions[] = "delete_{$modelName}";
            $permissions[] = "delete_any_{$modelName}";
            $permissions[] = "restore_{$modelName}";
            $permissions[] = "force_delete_{$modelName}";
        }

        // 3. Adiciona permissões extras comuns (opcional)
        $extraPermissions = [
            'access_filament', // para proteger o painel
            'manage_roles',
            'manage_permissions',
        ];

        $allPermissionNames = array_unique(array_merge($permissions, $extraPermissions));

        // 4. Cria todas as permissões no banco
        foreach ($allPermissionNames as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // 5. Atribui TODAS as permissões à role "super_admin"
        $superAdminRole->syncPermissions($allPermissionNames);

        // 6. Cria o usuário super admin (se não existir)
        $superAdminEmail = 'admin@ovana.com'; // 🔁 ALTERE PARA SEU EMAIL!

        if (! User::where('email', $superAdminEmail)->exists()) {
            $user = User::create([
                'name' => 'Super Admin',
                'email' => $superAdminEmail,
                'password' => bcrypt('12345678'), // 🔁 ALTERE A SENHA!
            ]);

            $user->assignRole('super_admin');
        }

        $this->command->info('✅ Super Admin criado com todas as permissões do Filament!');
    }
}
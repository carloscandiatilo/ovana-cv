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
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        $permissions = [];

        foreach (Filament::getResources() as $resource) {
            $model = $resource::getModel();
            $modelName = Str::snake(class_basename($model));

            $permissions[] = 'visualizar_qualquer_curriculum';
            $permissions = array_merge($permissions, [
                "visualizar_{$modelName}",
                "criar_{$modelName}",
                "editar_{$modelName}",
                "eliminar_{$modelName}",
            ]);
        }

        // Permissão para acessar o painel (opcional, mas útil)
        $permissions[] = 'acessar_painel';

        // Remove duplicados
        $permissions = array_unique($permissions);

        // Cria permissões no banco
        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // Atribui todas as permissões à role super_admin
        $superAdminRole->syncPermissions($permissions);

        // Cria super admin
        $email = 'admin@ovana.com';
        if (!User::where('email', $email)->exists()) {
            $user = User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => bcrypt('123456789'),
            ]);
            $user->assignRole('super_admin');
        }

        $this->command->info('✅ Super Admin criado com permissões em português!');
    }
}

//COMANDOS

// php artisan migrate:fresh --seed
// php artisan config:clear
// php artisan cache:clear
// composer dump-autoload


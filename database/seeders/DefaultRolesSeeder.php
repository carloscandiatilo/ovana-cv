<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'gestor_cv']);
    }
}
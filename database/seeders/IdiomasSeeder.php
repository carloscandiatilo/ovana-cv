<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Idioma;

class IdiomasSeeder extends Seeder
{
    public function run(): void
    {
        Idioma::insert([
            ['nome' => 'Português'],
            ['nome' => 'Inglês'],
            ['nome' => 'Espanhol'],
            ['nome' => 'Francês'],
            ['nome' => 'Alemão'],
            ['nome' => 'Outra'],
        ]);
    }
}

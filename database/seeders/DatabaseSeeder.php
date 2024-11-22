<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Executar o RoleSeeder primeiro
        $this->call([
            RoleSeeder::class,
            // outros seeders aqui...
        ]);
    }
}

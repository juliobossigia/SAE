<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Criar roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'servidor', 'guard_name' => 'web']);
        Role::create(['name' => 'docente', 'guard_name' => 'web']);
        Role::create(['name' => 'responsavel', 'guard_name' => 'web']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar roles
        $adminRole = Role::create(['name' => 'admin']);
        $servidorRole = Role::create(['name' => 'servidor']);
        $docenteRole = Role::create(['name' => 'docente']);
        $responsavelRole = Role::create(['name' => 'responsavel']);

        // Criar permissões básicas
        Permission::create(['name' => 'acessar_dashboard']);
        Permission::create(['name' => 'gerenciar_usuarios']);
        Permission::create(['name' => 'criar_registros']);
        Permission::create(['name' => 'editar_registros']);
        Permission::create(['name' => 'visualizar_registros']);

        // Criar permissões específicas
        Permission::create(['name' => 'gerenciar_cursos']);
        Permission::create(['name' => 'gerenciar_disciplinas']);
        Permission::create(['name' => 'gerenciar_departamentos']);
        Permission::create(['name' => 'gerenciar_setores']);
        Permission::create(['name' => 'visualizar_relatorios']);

        // Atribuir permissões ao admin
        $adminRole->givePermissionTo(Permission::all());

        // Atribuir permissões ao servidor
        $servidorRole->givePermissionTo([
            'acessar_dashboard',
            'criar_registros',
            'editar_registros',
            'visualizar_registros',
            'visualizar_relatorios'
        ]);

        // Atribuir permissões ao docente
        $docenteRole->givePermissionTo([
            'acessar_dashboard',
            'criar_registros',
            'editar_registros',
            'visualizar_registros',
            'gerenciar_disciplinas'
        ]);

        // Atribuir permissões ao responsável
        $responsavelRole->givePermissionTo([
            'acessar_dashboard',
            'visualizar_registros',
            'visualizar_relatorios'
        ]);
    }
}

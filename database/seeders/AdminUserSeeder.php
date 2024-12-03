<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        // Create the user
        $user = User::create([
            'name' => 'CDT user',
            'email' => 'cdt.projetos@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'cargo' => 'Desenvolvedor',
            'cpf' => '12345678901',
            'ativo' => true,
            'biografia' => 'CDT user é um usuário administrador do sistema.',
            'alt' => 'CDT user alt text',
            'imagem' => null,
            'linkedin' => 'https://linkedin.com/in/',
            'github' => 'https://github.com/',
            'passwordGoogle' => null,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create the role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Assign the role to the user
        $user->assignRole($role);
    }
}
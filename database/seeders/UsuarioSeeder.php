<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre'   => 'Admin',
            'ap'       => 'Papeleria',
            'am'       => 'Karla',
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Laravel cifra la contraseña automáticamente
            'role'     => 'admin', //
        ]);
    }
}
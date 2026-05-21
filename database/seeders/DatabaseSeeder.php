<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamando al seeder de roles
        $this->call([
            RoleSeeder::class
        ]);

        // Llamando al seeder de usuarios
        $this->call([
            UserSeeder::class
        ]);

        // Llamando a los demas seeders
        $this->call([
            ProductoSeeder::class,
            ColorSeeder::class,
            MaterialSeeder::class,
            ModeloSeeder::class,
            Detalle_tecnicoSeeder::class,
        ]);
    }
}

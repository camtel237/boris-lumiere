<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin de démonstration pour Boris — à changer avant la mise en prod.
        User::query()->firstOrCreate(
            ['email' => 'boris@borislumiere.com'],
            [
                'name' => 'Boris',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Marcos',
            'last_name' => 'Gonzales',
            'email' => 'marcos@example.org',
            'phone' => '123-456-7890',
            'password' => bcrypt('password'),
            'address' => [
                'street' => '123 Main St',
                'city' => 'Orem',
                'state' => 'UT',
                'zip' => '84088',
            ]
        ]);


        Tag::factory()->create([
            'name' => 'Electronics'
        ]);

        Tag::factory()->create([
            'name' => 'Computers'
        ]);

        Tag::factory()->create([
            'name' => 'Gaming devices'
        ]);
    }
}

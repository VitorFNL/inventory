<?php

namespace Database\Seeders;

use App\Models\EloquentProduct;
use App\Models\EloquentUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        EloquentUser::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        EloquentProduct::factory(10)->create();
    }
}

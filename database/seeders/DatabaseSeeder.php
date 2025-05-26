<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PlatformSeeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlatformSeeder::class,
            AdminUserSeeder::class,

        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Daftarkan SubbagianSeeder di sini
        $this->call(SubbagianSeeder::class);
    }
}

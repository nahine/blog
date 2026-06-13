<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Contenu officiel du blog (admin + articles avec photos)
        $this->call(FreshContentSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Source::create([
        'name' => 'Detik',
        'website' => 'https://detik.com'
    ]);
}

}

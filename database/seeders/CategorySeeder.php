<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $categories = [
        ['name'=>'Umum','slug'=>'umum'],
        ['name'=>'Nasional','slug'=>'nasional'],
        ['name'=>'Internasional','slug'=>'internasional'],
        ['name'=>'Ekonomi','slug'=>'ekonomi'],
        ['name'=>'Olahraga','slug'=>'olahraga'],
        ['name'=>'Teknologi','slug'=>'teknologi'],
        ['name'=>'Opini','slug'=>'opini'],
        ['name'=>'Forum','slug'=>'forum'],
    ];

    foreach ($categories as $cat) {
        \App\Models\Category::firstOrCreate($cat);
    }
}


}

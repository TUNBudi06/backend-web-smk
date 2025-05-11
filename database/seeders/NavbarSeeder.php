<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = ['Berita', 'Artikel'];
        $routes = ['/news', '/article'];
        $icons  = ['Diagrams', 'Eye'];

        $now = now('Asia/Jakarta');
        $data = [];

        foreach ($titles as $index => $title) {
            $data[] = [
                'title' => $title,
                'navbar_id' => 4,
                'route' => $routes[$index],
                'icon' => $icons[$index],
                'order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tb_sub_navbars')->insert($data);
    }
}

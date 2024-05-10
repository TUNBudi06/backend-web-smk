<?php

namespace Database\Seeders;

use App\Http\Controllers\data_manager;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tb_user_roles')->insert([
            [
                'name' => 'admin',
                'user_access' => data_manager::array2base(data_manager::accessRole()), // Example JSON array of user access
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        DB::table('tb_admins')->insert([
            [
                'name' => 'Budi',
                'username' => 'tunbudi06',
                'email' => 'budi@tun06.tech',
                'token' => "budi",
                'role' => 1, // Assuming role ID 1 is for the admin role
                'created_by' => 'Admin',
                'password' => Hash::make('budi123'), // Hash the password
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more admin records as needed
        ]);
        DB::table("tb_pemberitahuan_type")->insert([
            ["pemberitahuan_type_name"=> "artikel",
                'created_at' => now(),
                'updated_at' => now(),],
            ["pemberitahuan_type_name"=> "pengumuman",
                'created_at' => now(),
                'updated_at' => now(),],
            ["pemberitahuan_type_name"=> "berita",
                'created_at' => now(),
                'updated_at' => now(),],
            ["pemberitahuan_type_name"=> "event",
                'created_at' => now(),
                'updated_at' => now(),],
        ]);
    }
}

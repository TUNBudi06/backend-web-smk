<?php

namespace Database\Seeders;

use App\Models\BasicInformationModel;
use Illuminate\Database\Seeder;

class BasicInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BasicInformationModel::insert([
            [
                'name' => 'Twitter/X',
                'alias_name' => 'twitter',
                'logo' => 'x-logo.png',
                'url' => 'https://twitter.com/yourcompany',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Instagram',
                'alias_name' => 'instagram',
                'logo' => 'instagram-logo.png',
                'url' => 'https://instagram.com/yourcompany',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Facebook',
                'alias_name' => 'facebook',
                'logo' => 'facebook-logo.png',
                'url' => 'https://facebook.com/yourcompany',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Telegram',
                'alias_name' => 'telegram',
                'logo' => 'telegram-logo.png',
                'url' => 'https://t.me/yourcompany',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Email',
                'alias_name' => 'email',
                'logo' => 'email-icon.png',
                'url' => 'contact@yourcompany.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Phone',
                'alias_name' => 'phone',
                'logo' => 'phone-icon.png',
                'url' => '+1 (555) 123-4567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location',
                'alias_name' => 'location',
                'logo' => 'location-icon.png',
                'url' => '123 Business Street, Suite 100, City, Country, 12345',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

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
        $user = User::create([
            'telegram_id' => '202020',
            'password' => 'password',
        ]);

        $profileData = [
            'name' => 'Oleksiy',
            'age' => 20,
            'gender' => 'male',
            'location' => 'Munich'
        ];

        $images = [
            [
                'path' => 'image-1.png'
            ],
            [
                'path' => 'image-2.webp'
            ]
        ];

        $profile = $user->profile()->create($profileData);

        collect($images)->each(fn ($image) => $profile->images()->create($image));

        $user = User::create([
            'telegram_id' => '202021',
            'password' => 'password',
        ]);


        $profileData = [
            'name' => 'Maria',
            'age' => 21,
            'gender' => 'female',
            'location' => 'Munich'
        ];

        $images = [
            [
                'path' => 'test.jpg'
            ]
        ];

        $profile = $user->profile()->create($profileData);

        collect($images)->each(fn ($image) => $profile->images()->create($image));
    }
}

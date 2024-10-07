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
        $data = [
            [
                'telegram_id' => '202020',
                'name' => 'Oleksiy',
                'gender' => 'male',
                'image' => 'user.png'
            ],
            [
                'name' => 'Monica',
                'gender' => 'female',
                'image' => 'monica.png'
            ],
            [
                'name' => 'Lela',
                'gender' => 'female',
                'image' => 'lela.png'
            ],
            [
                'name' => 'Jenna',
                'gender' => 'female',
                'image' => 'jenna.png'
            ],
            [
                'name' => 'Maria',
                'gender' => 'female',
                'image' => 'maria.jpg'
            ],
        ];

        collect($data)->each(function ($item) {
            if (empty($item['telegram_id'])) {
                $item['telegram_id'] = fake()->numberBetween(200000, 205000);
            }

            $this->createUser($item['telegram_id'], $item['name'], $item['gender'], $item['image']);
        });
    }

    private function createUser($telegram_id, $name, $gender, $image)
    {
        $user = User::create([
            'telegram_id' => $telegram_id,
            'password' => 'password',
        ]);

        $profileData = [
            'name' => $name,
            'age' => fake()->numberBetween(20, 30),
            'gender' => $gender,
            'location' => 'Munich'
        ];


        $profile = $user->profile()->create($profileData);

        $preference = [
            'gender' =>  $gender === 'male' ? 'female' : 'male'
        ];

        if (fake()->boolean()) {
            $preference['age'] = fake()->numberBetween(18, 23);
        } else {
            $preference['min_age'] = fake()->numberBetween(18, 20);
            $preference['max_age'] = fake()->numberBetween(21, 25);
        }

        $user->preference()->create($preference);

        $profile->images()->create([
            'path' => $image
        ]);
    }
}

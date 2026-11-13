<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's public service categories.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Events Planning',
                'image' => 'e1558e1f-3982-4ddf-90b1-2e8b2be94644.jpg',
                'services' => ['Dowry', 'Weddings', 'Birthdays'],
            ],
            [
                'name' => 'Tours & Travel',
                'image' => 'addd183d-6007-4bee-a28d-ea80f54503da.jpg',
                'services' => ['Hotel Bookings', 'Destinations', 'Ticketing'],
            ],
            [
                'name' => 'Car Hire',
                'image' => 'd5515acf-defc-4ce2-8cfb-faf1b7f0cb2d.jpg',
                'services' => ['Airport Pickup', 'Offroad Vehicles'],
            ],
        ];

        foreach ($categories as $category) {
            Categories::updateOrCreate(
                ['name' => $category['name']],
                [
                    'image' => $category['image'],
                    'services' => $category['services'],
                ],
            );
        }
    }
}

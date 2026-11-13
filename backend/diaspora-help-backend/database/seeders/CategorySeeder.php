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
                'services' => ['Dowry', 'Weddings', 'Birthdays'],
            ],
            [
                'name' => 'Tours & Travel',
                'services' => ['Hotel Bookings', 'Destinations', 'Ticketing'],
            ],
            [
                'name' => 'Car Hire',
                'services' => ['Airport Pickup', 'Offroad Vehicles'],
            ],
        ];

        foreach ($categories as $category) {
            Categories::updateOrCreate(
                ['name' => $category['name']],
                ['services' => $category['services']],
            );
        }
    }
}

<?php

use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = Carbon::now()->toDateTimeString();

        Category::insert([
            [
                'name' => 'Fruité',
                'slug' => 'fruite',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Boisson',
                'slug' => 'boisson',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Bonbon',
                'slug' => 'bonbon',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Gourmand',
                'slug' => 'gourmand',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}

<?php

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Coupon::create([
            'code' => 'NEW2021',
            'value' => 2,
        ]);

        Coupon::create([
            'code' => 'WINTER',
            'value' => 1,
        ]);

        Coupon::create([
            'code' => 'GIGACOUPON',
            'value' => 5,
        ]);
    }
}

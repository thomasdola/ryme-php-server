<?php
use App\VouchResponse;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:22 PM
 */
class VouchResponseTableSeeder extends Seeder
{

    public function run()
    {
        factory(VouchResponse::class, 1000)->create();
    }
}
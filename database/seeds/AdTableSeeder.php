<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:01 PM
 */
class AdTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ad::class, 50)->create();
    }
}
<?php
use App\View;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 2:11 PM
 */
class ViewTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(View::class, 2000)->create();
    }
}
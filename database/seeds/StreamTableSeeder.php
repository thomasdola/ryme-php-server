<?php
use App\Stream;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 2:04 PM
 */
class StreamTableSeeder extends Seeder
{

    public function run()
    {
        factory(Stream::class, 2000)->create();
    }
}
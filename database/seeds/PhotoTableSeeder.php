<?php
use App\Photo;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 2:07 PM
 */
class PhotoTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Photo::class, 200)->create();
    }
}
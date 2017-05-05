<?php
use App\Favorite;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:14 PM
 */
class FavoriteTableSeeder extends Seeder
{

    public function run()
    {
        factory(Favorite::class, 1000)->create();
    }
}
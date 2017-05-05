<?php
use App\Download;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:13 PM
 */
class DownloadTableSeeder extends Seeder
{

    public function run()
    {
        factory(Download::class, 1000)->create();
    }
}
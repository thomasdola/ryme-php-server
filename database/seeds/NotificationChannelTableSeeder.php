<?php
use App\NotificationChannel;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 2:09 PM
 */
class NotificationChannelTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NotificationChannel::class, 200)->create();
    }
}
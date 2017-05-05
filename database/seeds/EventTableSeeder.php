<?php
use App\Event;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 2:12 PM
 */
class EventTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Event::class, 20)->create();
    }
}
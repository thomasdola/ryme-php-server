<?php
use Illuminate\Database\Seeder;

class TrackTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Track::class, 50)->create();
    }
}
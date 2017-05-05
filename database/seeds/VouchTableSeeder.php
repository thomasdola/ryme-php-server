<?php
use App\User;
use App\Vouch;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:16 PM
 */
class VouchTableSeeder extends Seeder
{

    public function run()
    {
        factory(Vouch::class, User::where('is_request_active', true)->count())->create();
    }
}
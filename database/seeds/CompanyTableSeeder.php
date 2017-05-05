<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/20/2016
 * Time: 12:11 PM
 */
class CompanyTableSeeder extends Seeder
{

    public function run()
    {
        factory(App\Company::class, 5)->create();
    }
}
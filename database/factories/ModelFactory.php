<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\View;
use App\Ad;
use App\Category;
use App\Comment;
use App\Company;
use App\Download;
use App\Event;
use App\Favorite;
use App\Following;
use App\NotificationChannel;
use App\Photo;
use App\Stream;
use App\Track;
use App\User;
use App\Vouch;
use App\File;
use App\VouchResponse;
use Carbon\Carbon;

$factory->defineAs(User::class, 'user', function (Faker\Generator $fake) {
    return [
        'uuid' => $fake->uuid,
        'name' => $fake->name,
        'gender' => 1,
        'phone' => $fake->phoneNumber,
        'country' => $fake->country,
        'username' => $fake->userName,
        'type' => 'user',
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(User::class, 'artist', function (Faker\Generator $fake) {
    return [
        'uuid' => $fake->uuid,
        'name' => $fake->name,
        'phone' => $fake->phoneNumber,
        'gender' => 1,
        'country' => $fake->country,
        'stage_name' => $fake->userName,
        'username' => $fake->userName,
        'type' => 'user',
        'category_id' => 1,
        'is_artist' => true,
        'artist_on' => Carbon::now(),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(User::class, 'user_with_request', function (Faker\Generator $fake) {
    return [
        'uuid' => $fake->uuid,
        'name' => $fake->name,
        'phone' => $fake->phoneNumber,
        'gender' => 1,
        'country' => $fake->country,
        'stage_name' => $fake->userName,
        'username' => $fake->userName,
        'type' => 'user',
        'category_id' => 1,
        'is_request_active' => true,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(User::class, 'staff', function (Faker\Generator $fake) {
    return [
        'uuid' => $fake->uuid,
        'name' => $fake->name,
        'gender' => 1,
        'type' => 'staff',
        'email' => $fake->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Track::class, function (Faker\Generator $fake) {
    return [
        'uuid' => $fake->uuid,
        'title' => $fake->sentence(2),
        'user_id' => collect(User::where('is_artist', true)->lists('id'))->random(),
        'released_date' => Carbon::parse($fake->date()),
        'category_id' => collect(Category::all()->lists('id'))->random()
    ];
});

$factory->define(Category::class, function(Faker\Generator $fake){
    return [
        'name' => $fake->sentence(2),
        'uuid' => $fake->uuid
    ];
});

$factory->define(Ad::class, function(Faker\Generator $fake){
    return [
        'uuid' => $fake->uuid,
        'title' => $fake->sentence(2),
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDays(7),
        'is_active' => $fake->boolean(80),
        'company_id' => collect(Company::all()->lists('id'))->random()
    ];
});

$factory->define(Company::class, function(Faker\Generator $fake){
    return [
        'name'=>$fake->company,
        'uuid'=>$fake->uuid
    ];
});

$factory->define(Download::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'track_id'=>collect(Track::all()->lists('id'))->random()
    ];
});

$factory->define(Favorite::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'track_id'=>collect(Track::all()->lists('id'))->random()
    ];
});

$factory->define(Vouch::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::where('is_request_active', true)->lists('id'))->random(),
        'uuid'=> $fake->uuid,
        'is_active'=> true,
        'start_date'=>Carbon::now()->startOfDay(),
        'end_date'=>Carbon::now()->startOfDay()->addDays(14),
    ];
});

$factory->define(VouchResponse::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'vouch_id'=>collect(Vouch::where('is_active', true)->lists('id'))->random(),
        'answer'=>$fake->boolean(90)
    ];
});

$factory->define(Comment::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'track_id'=>collect(Track::all()->lists('id'))->random(),
        'body'=>$fake->sentence
    ];
});

$factory->define(Stream::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'streamable_id'=>collect(Track::all()->lists('id'))->merge(Ad::all()->lists('id'))->random(),
        'streamable_type'=>collect(['App\Track', 'App\Ad'])->random(),
    ];
});

$factory->define(Following::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::where('is_artist', true)->lists('id'))->take(5)->random(),
        'followable_id'=>collect(Category::all()->lists('id'))
            ->merge(User::where('is_artist', true)->lists('id'))->random(),
        'followable_type'=>collect(['App\Category', 'App\User'])->random(),
    ];
});

$factory->defineAs(Photo::class, 'artist_back', function(Faker\Generator $fake){
    return [
        'type'=>'background',
        'extension'=>'jpg',
        'uuid'=>$fake->uuid,
        'path'=>$fake->imageUrl(),
        'imageable_id'=>1,
        'imageable_type'=>'App\User'
    ];
});

$factory->defineAs(Photo::class, 'user_avatar', function(Faker\Generator $fake){
    return [
        'type'=>'avatar',
        'uuid'=>$fake->uuid,
        'extension'=>'jpg',
        'path'=>$fake->imageUrl(),
        'imageable_id'=>1,
        'imageable_type'=>'App\User'
    ];
});

$factory->defineAs(Photo::class, 'track_cover', function(Faker\Generator $fake){
    return [
        'type'=>'cover',
        'uuid'=>$fake->uuid,
        'path'=>$fake->imageUrl(),
        'extension'=>'jpg',
        'imageable_id'=>1,
        'imageable_type'=>'App\Track'
    ];
});

$factory->defineAs(Photo::class, 'event_ad_cover', function(Faker\Generator $fake){
    return [
        'type'=>'cover',
        'extension'=>'jpg',
        'uuid'=>$fake->uuid,
        'path'=>$fake->imageUrl(),
        'imageable_id'=>1,
        'imageable_type'=>'App\Event'
    ];
});

$factory->define(NotificationChannel::class, function(Faker\Generator $fake){
    return [
        'name'=>$fake->word,
        'uuid'=>$fake->uuid,
        'channelable_id'=>collect(Category::all()->lists('id'))
            ->merge(User::where('is_artist', true)->lists('id'))->random(),
        'channelable_type'=>collect(['App\Category', 'App\User', 'App\Track'])->random(),
    ];
});

$factory->define(File::class, function(Faker\Generator $fake){
    return [
        'path'=>'aws.s3.amazon.com/'.$fake->word.$fake->uuid.'mp3',
        'uuid'=>$fake->uuid,
        'filable_id'=>collect(Track::all()->lists('id'))->random(),
        'filable_type'=>'App\Track',
    ];
});

$factory->define(View::class, function(Faker\Generator $fake){
    return [
        'user_id'=>collect(User::all()->lists('id'))->random(),
        'viewable_id'=>collect(Event::all()->lists('id'))
            ->merge(Track::all()->lists('id'))->random(),
        'viewable_type'=>collect(['App\Track', 'App\Event'])->random(),
    ];
});

$factory->define(Event::class, function(Faker\Generator $fake){
    return [
        'title'=>$fake->title,
        'uuid'=>$fake->uuid,
        'description'=>$fake->text,
        'time'=>$fake->time(),
        'date'=>Carbon::now()->addDays(2),
        'start_date'=>Carbon::now(),
        'end_date'=>Carbon::now()->addDays(2)->startOfDay(),
        'is_active'=>$fake->boolean(80)
    ];
});
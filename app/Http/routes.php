<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web'], 'prefix'=>'admin'], function () {

    Route::get('/auth/login', ['as' => 'getLogin', 'uses' => 'AdminAuthController@login']);
    Route::post('/auth/login', ['as' => 'postLogin', 'uses' => 'AdminAuthController@postLogin']);
    Route::get('/auth/logout', ['as' => 'logout', 'uses' => 'AdminAuthController@logout']);

    Route::group(['middleware' => 'web'], function(){
        Route::get('/dashboard',['as'=>'dashboard', 'uses'=>'PagesController@dashboard']);
        Route::get('/artists', ['as'=>'artists', 'uses'=>'ArtistsController@index']);
        Route::get('/artists/{id}', ['as'=>'artists.show', 'uses'=>'ArtistsController@show']);
        Route::resource('categories', 'CategoriesController');
        Route::resource('users', 'UsersController');
        Route::resource('ads', 'AdsController');
        Route::get('/settings', ['as'=>'settings', 'uses'=>'AdminController@index']);
    });

});

Route::group(['prefix'=>'admin/internal', 'middleware' => ['api']], function(){

    Route::group(['namespace'=>'InternalApi'], function(){

        Route::get('/local/search', ['as'=>'users.search', 'uses'=>'SearchLocalApiController@search']);
        Route::get('/dashboard/total-users', ['uses'=>'UsersApiController@totalUsers']);
        Route::get('/dashboard/total-tracks', ['uses'=>'TrackApiController@totalTracks']);
        Route::get('/dashboard/total-artists', ['uses'=>'ArtistApiController@totalArtists']);
        Route::get('/dashboard/total-ads', ['uses'=>'AudioAdApiController@totalAds']);
        Route::get('/dashboard/trending-tracks', ['uses'=>'TrackApiController@getTrendingTracks']);
        Route::get('/dashboard/top-artists', ['uses'=>'ArtistApiController@topArtists']);

        //Artists Page Internal Api ==> sort of (:)
        Route::get('/artists', ['as'=>'artists.all', 'uses'=>'ArtistApiController@all']);
        Route::get('/artists/data', ['as'=>'artists.page.data', 'uses'=>'ArtistApiController@getIndexPageData']);
        Route::get('/artists/trending', ['as'=>'artists.trending', 'uses'=>'ArtistApiController@trending']);
        Route::get('/artists/requests', ['as'=>'artists.requests', 'uses'=>'ArtistApiController@requests']);
        Route::get('/artists/{id}', ['as'=>'artists.single', 'uses'=>'ArtistApiController@single']);

        //Category Page Internal Api ==> kind of (:)
        Route::get('/categories', ['as'=>'categories.all', 'uses'=>'CategoryApiController@all']);
        Route::post('/categories', ['as'=>'categories.create', 'uses'=>'CategoryApiController@store']);
        Route::get('/categories/{id}', ['as'=>'categories.single', 'uses'=>'CategoryApiController@single']);
        Route::delete('/categories/{id}', ['as'=>'categories.delete', 'uses'=>'CategoryApiController@delete']);
        Route::put('/categories/{id}', ['as'=>'categories.update', 'uses'=>'CategoryApiController@update']);

        //Users Page Internal Api ==> think so (:)
        Route::get('/users', ['as'=>'users.all', 'uses'=>'UsersApiController@all']);
        Route::get('/users/data', ['as'=>'users.data', 'uses'=>'UsersApiController@indexPageData']);
        Route::get('/users/{id}', ['as'=>'users.single', 'uses'=>'UsersApiController@single']);
        Route::put('/users/{id}', ['as'=>'users.update', 'uses'=>'UsersApiController@update']);
        Route::delete('/users/{id}', ['as'=>'users.delete', 'uses'=>'UsersApiController@delete']);

        //Ad page Internal Api ==> all hack (:)
        Route::resource('/ad-sections', 'AdSessionsController', ['except'=>['show', 'edit', 'create']]);

        Route::get('/audio-ads', ['as'=>'audio.ads.all', 'uses'=>'AudioAdApiController@all']);
        Route::get('/audio-ads/data', ['as'=>'ad.page.data', 'uses'=>'AudioAdApiController@getIndexPageData']);
        Route::get('/audio-ads/{id}', ['as'=>'audio.ads.single', 'uses'=>'AudioAdApiController@single']);
        Route::post('/audio-ads', ['as'=>'audio.ads.create', 'uses'=>'AudioAdApiController@store']);
        Route::put('/audio-ads/{id}', ['as'=>'audio.ads.update', 'uses'=>'AudioAdApiController@update']);

        Route::get('/event-ads', ['as'=>'event.ads.all', 'uses'=>'EventAdApiController@all']);
        Route::get('/event-ads/{id}', ['as'=>'event.ads.single', 'uses'=>'EventAdApiController@single']);
        Route::put('/event-ads/{id}', ['as'=>'event.ads.update', 'uses'=>'EventAdApiController@update']);
        Route::post('/event-ads', ['as'=>'event.ads.create', 'uses'=>'EventAdApiController@store']);

        Route::get('/companies', ['as'=>'companies.all', 'uses'=>'CompanyApiController@all']);
        Route::post('/companies', ['as'=>'companies.create', 'uses'=>'CompanyApiController@store']);
        Route::get('/companies/{id}', ['as'=>'companies.single', 'uses'=>'CompanyApiController@single']);
        Route::put('/companies/{id}', ['as'=>'companies.update', 'uses'=>'CompanyApiController@update']);
        Route::delete('/companies/{id}', ['as'=>'companies.delete', 'uses'=>'CompanyApiController@delete']);

        //Admin Settings Page Internal Api really scary (:)
        Route::get('/staffs', ['as'=>'staff.all', 'uses'=>'StaffApiController@all']);
        Route::get('/staffs/{id}', ['as'=>'staff.single', 'uses'=>'StaffApiController@single']);
        Route::post('/staffs', ['as'=>'staff.create', 'uses'=>'StaffApiController@store']);
        Route::put('/staffs/{id}', ['as'=>'staff.update', 'uses'=>'StaffApiController@update']);
        Route::delete('/staffs/{id}', ['as'=>'staff.delete', 'uses'=>'StaffApiController@delete']);

        Route::get('/roles', ['as'=>'role.all', 'uses'=>'RolesApiController@all']);
        Route::get('/roles/{id}', ['as'=>'role.single', 'uses'=>'RolesApiController@single']);
        Route::post('/roles', ['as'=>'role.create', 'uses'=>'RolesApiController@store']);
        Route::put('/roles/{id}', ['as'=>'role.update', 'uses'=>'RolesApiController@update']);
        Route::delete('/roles/{id}', ['as'=>'role.delete', 'uses'=>'RolesApiController@delete']);
    });
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api){
    $api->post('register', ['as'=>'api.auth.register', 'uses'=>'App\Http\Controllers\Auth\ApiAuthController@register']);
    $api->post('verify', ['as'=>'api.auth.verify-otp', 'uses'=>'App\Http\Controllers\Auth\ApiAuthController@verifyOtp']);
    $api->post('login', ['as'=>'api.auth.login', 'uses'=>'App\Http\Controllers\Auth\ApiAuthController@authenticate']);
    $api->group(['middleware'=>['api.auth']], function($api){
        $api->get('categories/lists', ['as'=>'api.categories.lists', 'uses'=>'App\Http\Controllers\AppApi\CategoriesController@lists']);
        $api->post('categories/follow', ['as'=>'api.categories.bulk_follow', 'uses'=>'App\Http\Controllers\AppApi\CategoriesController@bulkFollow']);
        $api->post('categories/{uuid}/follow', ['as'=>'api.category.follow', 'uses'=>'App\Http\Controllers\AppApi\CategoriesController@follow']);
        $api->post('categories/{uuid}/unfollow', ['as'=>'api.category.unFollow', 'uses'=>'App\Http\Controllers\AppApi\CategoriesController@unFollow']);

        $api->get('search', ['as'=>'api.search', 'uses'=>'App\Http\Controllers\AppApi\SearchController@search']);

        $api->get('/tracks/lists', ['as'=>'api.tracks.lists', 'uses'=>'App\Http\Controllers\AppApi\TracksController@lists']);
        $api->get('/tracks/{uuid}', ['as'=>'api.track.show', 'uses'=>'App\Http\Controllers\AppApi\TracksController@show']);
        $api->post('/tracks/{uuid}/stream', ['as'=>'api.track.stream', 'uses'=>'App\Http\Controllers\AppApi\TracksController@stream']);
        $api->post('/tracks/{uuid}/like', ['as'=>'api.track.like', 'uses'=>'App\Http\Controllers\AppApi\TracksController@like']);
        $api->post('/tracks/{uuid}/dislike', ['as'=>'api.track.dislike', 'uses'=>'App\Http\Controllers\AppApi\TracksController@dislike']);
        $api->post('/tracks/{uuid}/download', ['as'=>'api.track.download', 'uses'=>'App\Http\Controllers\AppApi\TracksController@download']);
        $api->post('/tracks/{uuid}/update', ['as'=>'api.track.update', 'uses'=>'App\Http\Controllers\AppApi\TracksController@updateInfo']);
        $api->post('/tracks/{uuid}/comment', ['as'=>'api.track.comment', 'uses'=>'App\Http\Controllers\AppApi\CommentsController@comment']);
        $api->get('/tracks/{uuid}/comments', ['as'=>'api.track.comments', 'uses'=>'App\Http\Controllers\AppApi\CommentsController@comments']);

        $api->get('/events/lists', ['as'=>'api.events.lists', 'uses'=>'App\Http\Controllers\AppApi\EventsController@lists']);
        $api->post('/events/{uuid}/view', ['as'=>'api.events.view', 'uses'=>'App\Http\Controllers\AppApi\EventsController@view']);

        $api->get('/artists/{uuid}', ['as'=>'api.artist.show', 'uses'=>'App\Http\Controllers\AppApi\ArtistsController@show']);
        $api->post('/artists/{uuid}/follow', ['as'=>'api.artist.follow', 'uses'=>'App\Http\Controllers\AppApi\ArtistsController@follow']);
        $api->post('/artists/{uuid}/unfollow', ['as'=>'api.artist.unFollow', 'uses'=>'App\Http\Controllers\AppApi\ArtistsController@unFollow']);
        $api->post('/artists/{uuid}/update', ['as'=>'api.artist.update', 'uses'=>'App\Http\Controllers\AppApi\ArtistsController@update']);
        $api->get('/artists/{uuid}/tracks', ['as'=>'api.artist.tracks', 'uses'=>'App\Http\Controllers\AppApi\TracksController@artistTracks']);

        $api->get('/user/categories', ['as'=>'api.user.categories', 'uses'=>'App\Http\Controllers\AppApi\UsersController@followedCategories']);
        $api->get('/user/favorites', ['as'=>'api.users.favorites', 'uses'=>'App\Http\Controllers\AppApi\UsersController@favorites']);
        $api->post('/user/update', ['as'=>'api.users.update', 'uses'=>'App\Http\Controllers\AppApi\UsersController@update']);
        $api->post('/user/photo', ['as'=>'api.users.photo', 'uses'=>'App\Http\Controllers\AppApi\UsersController@photo']);
        $api->post('/artist/upload', ['as'=>'api.artist.upload', 'uses'=>'App\Http\Controllers\AppApi\ArtistsController@upload']);
        $api->get('/user/allowed', ['as'=>'api.request.allowed', 'uses'=>'App\Http\Controllers\AppApi\UsersController@isAllowedToBeArtist']);

        $api->post('/request/make', ['as'=>'api.request.make', 'uses'=>'App\Http\Controllers\AppApi\VouchesController@makeSendRequest']);
        $api->post('/vouch/{uuid}/answer', ['as'=>'api.vouch.answer', 'uses'=>'App\Http\Controllers\AppApi\VouchesController@answer']);
    });
});

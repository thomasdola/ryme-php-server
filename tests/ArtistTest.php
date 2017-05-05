<?php

use App\Category;
use App\Photo;
use App\User;
use App\Vouch;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArtistTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_fetches_all_artists()
    {
        factory(Category::class, 2)->create();
        factory(User::class, 'artist')->create();
        factory(Photo::class, 'user_avatar')->create();
        factory(Photo::class, 'artist_back')->create();

        $this->get('admin/internal/artists');

        $this->seeJson();
    }

    /** @test */
    public function it_fetches_trending_artists()
    {
        factory(Category::class, 2)->create();
        factory(User::class, 'artist')->create();
        factory(Photo::class, 'user_avatar')->create();
        factory(Photo::class, 'artist_back')->create();

        $this->get('admin/internal/artists/trending');

        $this->seeJson();
    }

    /** @test */
    public function it_fetches_a_single_artist()
    {
        factory(Category::class, 2)->create();
        $artist = factory(User::class, 'artist')->create();
        factory(Photo::class, 'user_avatar')->create();
        factory(Photo::class, 'artist_back')->create();

        $this->get("admin/internal/artists/{$artist->uuid}");

        $this->seeJson([
                'id' => $artist->uuid
            ]);
    }

    /** @test */
    public function it_fetches_users_that_want_to_launched_artist_request()
    {
        factory(Category::class)->create();
        $user = factory(User::class, 'user_with_request')->create();
        factory(Photo::class, 'user_avatar')->create();
        factory(Vouch::class)->create();
        $this->get('admin/internal/artists/requests');

        $arr = [
            'stage_name' => $user->stage_name
        ];

        $this->seeJson();
    }
}

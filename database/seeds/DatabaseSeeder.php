<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['users', 'tracks', 'categories',
        'ads', 'vouch_responses', 'companies','vouches', 'downloads',
        'favorites', 'comments', 'streams', 'followings', 'photos', 'notification_channels',
        'files', 'views', 'events'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->toTruncate as $table){
            DB::table($table)->truncate();
        }
        $this->call(CategoryTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TrackTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(AdTableSeeder::class);
//        $this->call(DownloadTableSeeder::class);
//        $this->call(FavoriteTableSeeder::class);
        $this->call(EventTableSeeder::class);
//        $this->call(VouchTableSeeder::class);
//        $this->call(VouchResponseTableSeeder::class);
//        $this->call(CommentTableSeeder::class);
//        $this->call(StreamTableSeeder::class);
        $this->call(FollowingTableSeeder::class);
//        $this->call(PhotoTableSeeder::class);
//        $this->call(NotificationChannelTableSeeder::class);
//        $this->call(ViewTableSeeder::class);
//        $this->call(FileTableSeeder::class);
    }
}

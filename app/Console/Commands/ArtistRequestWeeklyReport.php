<?php

namespace App\Console\Commands;

use App\Events\VouchRequestReachedHalfTime;
use App\Vouch;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ArtistRequestWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist-request:weekly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send last 7 days report to user that made the request.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastWeek = Carbon::today()->subWeek()->startOfDay();
        Vouch::with('user', 'channel', 'responses')
            ->where('is_active', '1')->where('start_date', $lastWeek)
            ->each(function(Vouch $vouch){
                event(new VouchRequestReachedHalfTime($vouch));
            });
    }
}

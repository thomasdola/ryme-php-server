<?php

namespace App\Console\Commands;

use App\Events\VouchRequestWasDue;
use App\Vouch;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ArtistRequestManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist-request:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily check for artists request';

    /**
     * Create a new command instance.
     *
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
        $today = Carbon::today()->endOfDay();
        Vouch::with('user', 'channel', 'responses')
            ->where('is_active', '1')->where('end_date', $today)
            ->each(function(Vouch $vouch){
                $vouch->update(['is_active'=>false]);
                event(new VouchRequestWasDue($vouch));
            });
    }
}

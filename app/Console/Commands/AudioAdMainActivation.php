<?php

namespace App\Console\Commands;

use App\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AudioAdMainActivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio-ads:main-activation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily check to see whether a particular audio-ad start_date is due
                                -> start_date (is_active)';

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
        $headers = ['title', 'is_active', 'is_section_active'];
        $ads = collect(Ad::where('is_active', '0')->lists('title', 'is_active', 'is_section_active'));

        if($ads->isEmpty()) return;

        $this->table($headers, $ads);

        $early_today = Carbon::today()->startOfDay();

        $ads->each(function(Ad $ad) use($early_today){
            $ad_start_day = Carbon::parse($ad->start_date)->startOfDay();
            if($ad_start_day->eq($early_today)){
                $ad->update(['is_active' => true]);
            }
        });
    }
}

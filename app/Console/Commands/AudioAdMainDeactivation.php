<?php

namespace App\Console\Commands;

use App\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AudioAdMainDeactivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio-ads:main-deactivation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily check to see whether a particular audio-ad end_date is due
                                -> end_date (is_active)';

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
        $ads = collect(Ad::where('is_active', '1')->get());
        if($ads->isEmpty()) return;
        $late_today = Carbon::today()->endOfDay();
        $ads->each(function(Ad $ad) use($late_today){
            $ad_end_day = Carbon::parse($ad->end_date)->endOfDay();
            if($ad_end_day->eq($late_today)){
                $ad->update([
                    'is_active'=>false,
                    'is_section_active'=>false
                ]);
            }
        });
    }
}

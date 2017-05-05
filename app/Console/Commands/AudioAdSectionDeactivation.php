<?php

namespace App\Console\Commands;

use App\Ad;
use App\AdSection;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AudioAdSectionDeactivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio-ads:section-deactivation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily check to see whether a particular audio-ad daily section end_time is due
                                -> section->end_time (is_section_active)';

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
        $current = Carbon::now();
        $current_section = AdSection::with('audio_ads')
            ->where('start_time', '<=', $current)
            ->where('end_time', '>', $current)->first();
        collect($current_section->audio_ads->all())
            ->where('is_active', '1')->where('is_section_active', '1')
            ->each(function(Ad $ad){
                $ad->update(['is_section_active', false]);
            });
    }
}

<?php

namespace App\Console\Commands;

use App\AdSection;
use App\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EventAdSectionActivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event-ads:section-activation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily check to see whether a particular event-ad daily section start_time is due
                                -> section->start_time (is_section_active)';

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
        $current = Carbon::now();

        $current_section = AdSection::with('event_ads')
            ->where('start_time', '<=', $current)
            ->where('end_time', '>', $current)->first();

        collect($current_section->event_ads->all())
            ->where('is_active', '1')->where('is_section_active', '0')
            ->each(function(Event $ad){
                $ad->update(['is_section_active' => true]);
            });
    }
}

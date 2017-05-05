<?php

namespace App\Console\Commands;

use App\AdSection;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateAdSectionTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad-section:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Ad section times to conform to today\'s time';

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
        $headers = ['name', 'start time', 'end time'];
        $sections = collect(AdSection::all());
        if($sections->isEmpty()) return;
        $this->table($headers, $sections);
        $sections->each(function(AdSection $section){
            $start_time_hour = Carbon::parse($section->start_time)->hour;
            $start_time_min = Carbon::parse($section->start_time)->minute;
            $end_time_hour = Carbon::parse($section->end_time)->hour;
            $end_time_min = Carbon::parse($section->end_time)->minute;
            $new_start_time = Carbon::today()->hour($start_time_hour)->minute($start_time_min);
            $new_end_time = Carbon::today()->hour($end_time_hour)->minute($end_time_min);
            $section->update(['start_time'=>$new_start_time, 'end_time'=>$new_end_time]);
        });
        $sections = collect(AdSection::all());
        $this->table($headers, $sections);
    }
}

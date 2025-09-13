<?php

namespace App\Console\Commands;
use App\Models\daily;
use Illuminate\Console\Command;

class ResetDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
 
        daily::query()->update(['count'=>0]);
    }
}

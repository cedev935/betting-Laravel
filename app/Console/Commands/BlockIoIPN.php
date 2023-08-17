<?php

namespace App\Console\Commands;

use Facades\App\Services\BasicCurl;
use Illuminate\Console\Command;

class BlockIoIPN extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockIo:ipn';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block IO IPN cron';

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
     * @return int
     */
    public function handle()
    {
        $url = route('ipn', 'blockio');
        BasicCurl::curlGetRequest($url);
    }
}

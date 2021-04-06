<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ProcessContactFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contactFiles:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will process the files uploaded with contacts per user.';

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
        DB::table('files')->where("state", "wait")->update( ["state" => "complete"] );
    }
}

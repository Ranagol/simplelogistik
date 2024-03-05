<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command for testing stuff';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "Test command succesully eecuted." . PHP_EOL;
    }
}

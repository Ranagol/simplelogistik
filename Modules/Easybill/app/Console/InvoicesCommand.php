<?php

namespace Modules\Easybill\app\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InvoicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'send-invoices {setting=none : (setting=enable) Enables the module; (setting=disable) Disables the module} {-h|--help?}';

    /**
     * The console command description.
     */
    protected $description = 'Send invoice(s) to easybill.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {        
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->handleStatus();

        

        $this->info($this->description);
        $this->info(json_encode($this->getData(['firstname' => 'User', 'lastname' => 'Test', 'email' => ''])));
    }

    /**
     * Handle the status of the module.
     * @return $module
     */
    private function handleStatus() 
    {
        $module = Module::find('Easybill');
        $setting = $this->argument('setting');
        
        if ($setting == 'setting=disable') {            
            $this->info('New setting ' . $setting);
            $module->disable();
            $message = ['warning' => 'Easybill module is disabled!'];
            $this->info($message['warning']);
            die(json_encode($message));
        }        
        if ($setting == 'setting=enable') {            
            $this->info('New setting ' . $setting);
            $module->enable();
            $message = ['success' => 'Easybill module is enabled!'];
            $this->info($message['success']);
            die(json_encode($message));
        }

        if (Module::isDisabled('Easybill')) {
            $message = ['error' => 'Easybill module is disabled!'];
            $this->info($message['error']);
            die(json_encode($message));
        }

        return $module;
    }
    private function getData($data) {
        return $data;
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}

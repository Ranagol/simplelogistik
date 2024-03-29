<?php

namespace App\Providers;

use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->commands([
            \Modules\Easybill\app\Console\InvoicesCommand::class,
            \Modules\Easybill\app\Console\CustomersCommand::class,
            \Modules\EmonsInvoice\app\Console\GetEmonsInvoices::class,
            \Modules\PamyraOrder\app\Console\HandlePamyraOrders::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}

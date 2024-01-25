<?php

namespace App\Services;

use PHPUnit\Event\Runtime\PHP;

class PamyraDataHandlerService
{
    private string $pathToPamyraData;

    public function handle(): void
    {
        echo 'Handling Pamyra data has started.' . PHP_EOL;

        echo 'Handling Pamyra data has ended.' . PHP_EOL;
    }
}
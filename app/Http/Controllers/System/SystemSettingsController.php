<?php

namespace App\Http\Controllers\System;

use Inertia\Inertia;

class SystemSettingsController extends BaseController {
    public function __construct() {
        
    }

    public function listLanguages() {}
    public function listTranslations(Request $request, String $lang) {
        return Inertia::render(
            "System/Translations/EntriesList"
        )
    }
    public function storeTranslations() {}
}
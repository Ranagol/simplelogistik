<?php

namespace App\Http\Controllers\System;

use App\Http\Requests\LanguageRequest;
use App\Models\SystemLanguage;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Request;


use Inertia\Inertia;

class SystemSettingsController extends BaseController {
    public function __construct() {
        
    }


    public function listTranslations(Request $request, String $lang) {
        return Inertia::render(
            "System/Translations/EntriesList"
        );
    }

    public function listLanguages() {
        return Inertia::render('System/Languages/Index', [
            "languages" => SystemLanguage::with(["entries"])->get()->toArray()
        ]);


    }

    public function storeLanguages(Request $request) {
        $data = $request->only(['name', 'description', 'locale', 'flag', 'is_active']);
        $entry = SystemLanguage::create($data);
        $entries = SystemLanguage::with(["entries"])->get()->toArray();
        return Inertia::render("System/Languages/Index", [
            "languages" => $entries
        ]);
    }

    public function editLanguage(Request $request, $id) {
        $entry = SystemLanguage::findOrFail($id);
        return Inertia::render('System/Languages/Edit', [
            "language" => $entry->toArray()
        ]);
    }
    public function updateLanguage(LanguageRequest $request) {
        $system_language = SystemLanguage::find($request->id);
        $system_language->name = $request->name;
        $system_language->description = $request->description;
        $system_language->save();
    }

    public function deleteLanguage(Int $id) {
        $system_language = SystemLanguage::findOrFail($id);
        $system_language->delete();        
    }



    public function storeTranslations(Request $request) {

    }

}
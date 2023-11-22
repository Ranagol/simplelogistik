<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Experiment;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    public function index()
    {
        $experiments = Experiment::all();

        return Inertia::render('Experiment', [
            'experiments' => $experiments,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:255'],
            // 'description' => ['required'],
        ]);

        Experiment::create($request->all());
        return redirect()->back()
            ->with('message', 'Experiment created successfully.');
    }




}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->searchTerm;
        $page = $request->page;
        $sortByThis = $request->sortByThis;
        $sortDirection = $request->sortDirection;


        $users = User::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })

            //PAGINATION
            ->paginate(10);

            //Paginate the search result, but include the query string too into pagination data links for page 1,2,3,4... And the url will now include this too: http://127.0.0.1:8000/users?search=a&page=2 if we click on the searc results, page 2
            // ->withQueryString();

        $t = 8;
        return Inertia::render('Users/Index', [
            'dataFromUserController' => $users,
            // 'filters'=> [
            //     'searchTerm' => $searchTerm
            // ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

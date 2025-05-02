<?php

namespace App\Http\Controllers\Github;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\GithubContract;

class GithubRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(string $owner, GithubContract $githubService)
    {
        return $githubService->getRepositories($owner);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public static function show(string $owner, string $repositoryName, GithubContract $githubService)
    {
        return $githubService->getRepository($owner, $repositoryName);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}

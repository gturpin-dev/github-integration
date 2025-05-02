<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListGithubRepositoryLanguages extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $owner, string $repositoryName)
    {
        dd($owner, $repositoryName);
    }
}

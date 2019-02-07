<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
        $repos = Repository::getUserRepositories($username);
        $httpCode = count($repos)? 200: 404;

        return response()->json($repos, $httpCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $username)
    {
        $data = $request->all();

        $user = User::where('login', $username)
            ->first()??abort(404);

        $data['users_id'] = $user->id;
        $data['login'] = $user->login;

        $httpCode = 201;

        try {
            $repos = Repository::create($data);
        } catch (\Exception $e) {
            $httpCode = $e->getCode();
            $repos = ['messages' => json_decode($e->getMessage())];
        }
        
        return response()->json($repos, $httpCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Repository  $repository
     * @return \Illuminate\Http\Response
     */
    public function show(Repository $repository)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Repository  $repository
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repository $repository)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Repository  $repository
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repository $repository)
    {
        //
    }
}

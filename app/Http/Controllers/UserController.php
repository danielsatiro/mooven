<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GithubClient;

class UserController extends Controller
{
    private $git;

    public function __construct(GithubClient $git)
    {
        $this->git = $git;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
        $userRepos = $this->git->userRepos($user);

        $data = [
            'user' => $user,
            'userRepos' => $userRepos
        ];

        return view('user.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $httpCode = 201;

        try {
            $user = User::create($request->all());
        } catch (\Exception $e) {
            $httpCode = $e->getCode();
            $user = ['messages' => json_decode($e->getMessage())];
        }

        return response()->json($user, $httpCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::where('login', $username)->first();
        $httpCode = !empty($user)? 200: 404;

        return response()->json($user, $httpCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

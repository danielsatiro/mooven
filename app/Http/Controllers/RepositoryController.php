<?php

namespace App\Http\Controllers;

use App\Models\Repository;

use Illuminate\Http\Request;
use App\Services\GithubClient;

class RepositoryController extends Controller
{
    private $git;

    public function __construct(GithubClient $git)
    {
        $this->git = $git;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user)
    {
        $data = $request->all();

        $data['user'] = $user;

        try {
            Repository::updateOrCreate([
                'user' => $user,
                'name' => $data['name']
            ], $data);
        } catch (\Exception $e) {
            return back()->with('messages', json_decode($e->getMessage()));
        }

        return redirect(route('home'));
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
     * @param  \App\Models\Repository  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Repository::find($id)->delete();
        return back()->with('status', "Repositório apagado com sucesso");
    }

    public function search(Request $request)
    {
        $data = [
            'result' => $this->git->search($request->get('q', ''))
        ];

        return view('repository.search_result', $data);
    }
}

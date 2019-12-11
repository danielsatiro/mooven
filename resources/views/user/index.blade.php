@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Repositórios > {{ $user }}</div>
                        <div class="col text-right">

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Repositório</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userRepos as $repo)
                            <tr>
                                <td scope="col">{{ $repo->name }}</td>
                                <td scope="col">
                                    <a href="{{ route('repos.store', ['user' => $user]) }}" class=""
                                        onclick="event.preventDefault();
                                                      document.getElementById('repo-form-{!! $repo->name !!}').submit();" title="Favorito">
                                        <i class="far fa-star"></i>
                                    </a>
                                    <form id="repo-form-{{ $repo->name }}" action="{{ route('repos.store', ['user' => $user]) }}" method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="name" value="{{ $repo->name }}">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

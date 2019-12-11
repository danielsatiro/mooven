@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Repositórios</div>
                        <div class="col text-right">
                            <form method="GET" class="form-inline md-form form-sm mt-0" id="search_form">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="q" type="text" class="form-control form-control-sm ml-3" name="q" value="{{ request('q') }}" placeholder="{{ __('Search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info btn-rounded">
                                            <i class="fas fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="result">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Repositório</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repos as $repo)
                                <tr>
                                    <td scope="col">{{ $repo->user }}</td>
                                    <td scope="col">
                                        <a class="show-sub-item" href="{{ $repo->html_url }}" target="blank">
                                            {{ $repo->name }}
                                        </a>
                                    </td>
                                    <td scope="col">
                                        <a href="{{ route('repos.destroy', ['id' => $repo->id]) }}" class="delete"
                                            onclick="event.preventDefault();
                                                          document.getElementById('repo-form-{!! $repo->id !!}').submit();" title="{{ __('Delete') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <form id="repo-form-{{ $repo->id }}" action="{{ route('repos.destroy', ['id' => $repo->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col"></th>
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
</div>
@endsection

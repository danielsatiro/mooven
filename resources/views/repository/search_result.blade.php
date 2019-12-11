<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Usuário</th>
            <th scope="col">Repositório</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result->items as $repo)
        <tr>
            <td scope="col">{{ $repo->owner->login }}</td>
            <td scope="col">
                <a class="show-sub-item" href="{{ route('users.repos', ['user' => $repo->owner->login]) }}">
                    {{ $repo->name }}
                </a>
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
<ul>
    @foreach($games as $game)
        <li>
            <a href="{{ route('games.show', [$game]) }}">
                {{ $game->id }} ( {{ $game->configuration->name }}, {{ $game->submarines->count() }} players )
            </a>
        </li>
    @endforeach
</ul>
<a href="{{ route('games.create') }}">Create new game</a>

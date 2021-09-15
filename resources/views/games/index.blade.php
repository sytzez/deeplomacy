<h2>Games</h2>

<ul>
    @foreach($games as $game)
        <li>
            <a href="{{ route('games.show', [$game]) }}">
                {{ $game->configuration->name }} ({{ $game->aliveSubmarines->count() }} / {{ $game->configuration->max_num_of_players }})
            </a>
        </li>
    @endforeach
</ul>
<a href="{{ route('games.create') }}">Create new game</a>

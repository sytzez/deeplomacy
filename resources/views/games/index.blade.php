<ul>
    @foreach($games as $game)
        <li>{{ $game->id }} ( {{ $game->configuration->title }} )</li>
    @endforeach
</ul>
<a href="{{ route('games.create') }}">Create new game</a>

<p>Configuration: {{ $game->configuration->name }}</p>

<h2>
    Players
</h2>
<ul>
    @foreach($game->submarines as $submarine)
        <li>
            {{ $submarine->user->name }}
        </li>
    @endforeach
</ul>

{{--<a href="{{ route('games.join', [$game]) }}">Join game</a>--}}
<a href="{{ route('games.index') }}">Back</a>

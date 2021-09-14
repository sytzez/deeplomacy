<p>Configuration: {{ $game->configuration->name }}</p>

<h2>
    Joined
</h2>
<ul>
    @foreach($game->users as $user)
        <li>
            {{ $user->name }}
        </li>
    @endforeach
</ul>

<a href="{{ route('games.join', [$game]) }}">Join game</a>
<a href="{{ route('games.index') }}">Back</a>

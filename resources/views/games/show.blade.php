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

@if($game->isJoinedBy(auth()->user()))
    <a href="{{ route('games.leave', [$game]) }}">Leave game</a>
@else
    <a href="{{ route('games.join', [$game]) }}">Join game</a>
@endif
<a href="{{ route('games.index') }}">Back</a>

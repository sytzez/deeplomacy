<p>Configuration: {{ $game->configuration->name }}</p>

<h2>
    Players
</h2>
<ul>
    @foreach($game->submarines as $submarine)
        <li>
            {{ $submarine->user->name }}
            @if(! $submarine->user->is(auth()->user()))
                (you)
            @endif
            @if(! $submarine->is_alive)
                (dead)
            @endif
        </li>
    @endforeach
</ul>

@if($game->isJoinedBy(auth()->user()))
    <a href="{{ route('play.show', [$game]) }}">Start playing!</a>
    <a href="{{ route('games.leave', [$game]) }}">Leave game</a>
@else
    <a href="{{ route('games.join', [$game]) }}">Join game</a>
@endif
<a href="{{ route('games.index') }}">Back</a>

<ul>
    @foreach($configurations as $configuration)
        <li>{{ $configuration->title }} — {{ $configuration->description }}</li>
    @endforeach
</ul>
<a href="{{ route('games.index') }}">Back</a>

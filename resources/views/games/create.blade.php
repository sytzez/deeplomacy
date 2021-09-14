<form method="POST" action="{{ route('games.store') }}">
    @csrf

    <label for="configuration">Configuration:</label>
    <select name="configuration" id="configuration">
        @foreach($configurations as $configuration)
            <option value="{{ $configuration->id }}"
                    @if(old('configuration') === $configuration->id)
                        selected
                    @endif
            >
                {{ $configuration->name }} — {{ $configuration->description }}
            </option>
        @endforeach
    </select>
    @error('configuration')
        <p>{{ $message }}</p>
    @enderror

    <input type="submit" value="Create game">
</form>

<a href="{{ route('games.index') }}">Back</a>

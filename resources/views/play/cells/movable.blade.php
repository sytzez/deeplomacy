<form method="post" action="{{ route('play.move', [$game]) }}">
    @csrf

    <input type="hidden" name="x" value="{{ $cell->getPosition()->getX() }}">
    <input type="hidden" name="y" value="{{ $cell->getPosition()->getY() }}">
    <input class="btn-link" type="submit" value="🟦">

</form>

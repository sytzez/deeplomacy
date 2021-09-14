<html lang="en">
<body style="background: black">

<table cellspacing="0">
    <tbody>
    @foreach($grid->getRows() as $cells)
        <tr>
            @foreach($cells as $cell)
                <td @if($cell->isVisible())
                        style="background: blue"
                    @endif
                >
                    @if($cell->canMoveTowards())
                        <form method="post" action="{{ route('play.move', [$game]) }}">
                            @csrf

                            <input type="hidden" name="x" value="{{ $cell->getPosition()->getX() }}">
                            <input type="hidden" name="y" value="{{ $cell->getPosition()->getY() }}">
                            <input type="submit">
                            🟦
                        </form>
                    @elseif($cell->getSubmarine())
                        🚢
                    @else
                        🌊
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

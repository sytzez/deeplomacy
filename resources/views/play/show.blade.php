<html lang="en">
<head>
    <style>
        form {
            margin: 0;
        }

        input.btn-link {
            background: none;
            border:none;
            cursor: pointer;
            padding: 0;
        }
    </style>
</head>
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
                            <input class="btn-link" type="submit" value="🟦">

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

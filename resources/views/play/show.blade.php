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
<body style="background: black; color: white">

<p>Action points: {{ $mySubmarine->getActionPoints()->getAmount() }}</p>

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
                        @include('play.cells.movable', compact('game', 'cell'))
                    @elseif($cell->getSubmarine() && $cell->getSubmarine()->is($mySubmarine))
                        🚢
                    @elseif($cell->getSubmarine())
                        @include('play.cells.submarine', compact('game', 'cell'))
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

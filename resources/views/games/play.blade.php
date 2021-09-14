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
                                <a href="test">
                                    🟦
                                </a>
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

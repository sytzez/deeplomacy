<html lang="en">
    <body style="background: black">

        <table>
            <tbody>
            @foreach($grid->getRows() as $cells)
                <tr>
                    @foreach($cells as $cell)
                        <td>
                            @if($cell->isVisible())
                                🌊
                            @else
                                ⬛
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

    </body>
</html>

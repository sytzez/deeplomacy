<html lang="en">
    <body style="background: darkblue">

        <table style="border: no">
            <tbody>
            @foreach($grid->getRows() as $cells)
                <tr>
                    @foreach($cells as $cell)
                        <td>
                            @if($cell->isVisible())
                                @if($cell->getSubmarine())
                                    🚢
                                @else
                                    🟦
                                @endif
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')
</head>
<body>
    <table>
        <tbody>
            @for ($y = 1; $y <= 8; $y++)
                <tr>
                    @for ($x = 1; $x <= 8; $x++)
                        <td id="{{ $x . $y }}" class="square {{ (($x + $y) % 2 == 0) ? 'white' : 'black' }}"></td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</body>

<style>

td {
    border: 1px solid black;
    width: 100px;
    height: 100px;
    text-align: center;
}

.piece {
    width: 60px;
    height: 60px;
    margin: 0 auto;
    border: 1px solid black;
    border-radius: 50%;
}

.white {
    background-color: white;
}

.black {
    background-color: black;
}
</style>

</html>
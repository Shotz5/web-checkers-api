<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkers</title>
    @vite('resources/js/app.js')
</head>
<body>
    <table>
        <tbody>
            @for ($y = 1; $y <= 8; $y++)
                <tr>
                    @for ($x = 1; $x <= 8; $x++)
                        <td class="square {{ (($x + $y) % 2 == 0) ? 'white' : 'black' }}"
                            data-x="{{ $x }}"
                            data-y="{{ $y }}"
                        >
                            @foreach ($pieces as $piece)
                                @if ($piece->x == $x && $piece->y == $y && !$piece->taken)
                                    <p id="{{ $piece->id }}" class="piece {{ $piece->colour }}"></p>
                                @endif
                            @endforeach
                        </td>
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

<script>
window.addEventListener('load', function () {
    let pieces = document.getElementsByClassName('piece');
    let original = null;

    for (let piece of pieces) {
        piece.addEventListener("mousedown", function (e) {
            original = document.elementsFromPoint(e.pageX, e.pageY).find((ele, i) => {
                return ele.classList.contains("square");
            });

            this.style.position = "absolute";
            document.body.append(this);

            setPieceLocation(piece, e.pageX, e.pageY);

            piece.addEventListener('mousemove', convertEventToLocation);
        });
        piece.addEventListener('mouseup', movePiece);
    }

    // Set up Websocket listener
    Echo.channel('App.Models.Board.' + window.location.pathname.split("/").at(-1))
        .listen('RefereeUpdatedEvent', movePieceOnWebsocket);

    /**
     * Functions
     */

    function movePiece(e) {
        let destination = document.elementsFromPoint(e.pageX, e.pageY).find((ele, i) => {
            return ele.classList.contains("square");
        });

        axios.patch('/api/piece/' + this.id, { x: destination.dataset.x, y: destination.dataset.y })
            .then(response => {
                // // Preserve move
                console.log(response.data);
                this.style.position = null;
                this.style.left = null;
                this.style.top = null;
            })
            .catch(error => {
                // Reset piece back to original spot
                console.log(error.response.data);
                original.appendChild(this);
                this.style.position = null;
                this.style.left = null;
                this.style.top = null;
            });
    }

    function movePieceOnWebsocket(e) {
        let piece = document.getElementById(e.referee.piece.id);
        let takenPiece = document.getElementById(e.referee.takenPiece?.id);
        let newParent = document.querySelector("[data-x='" + e.referee.piece.x + "'][data-y='" + e.referee.piece.y + "']");
        piece.dataset.x = e.referee.piece.x;
        piece.dataset.y = e.referee.piece.y;

        if (takenPiece) {
            takenPiece.remove();
        }

        newParent.appendChild(piece);
    }

    function setPieceLocation(piece, x, y) {
        piece.style.left = x - piece.offsetWidth / 2 + 'px';
        piece.style.top = y - piece.offsetHeight / 2 + 'px';
    }

    function convertEventToLocation(event) {
        setPieceLocation(this, event.pageX, event.pageY);
    }
});
</script>

</html>
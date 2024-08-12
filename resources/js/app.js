import './bootstrap';
import 'axios';

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
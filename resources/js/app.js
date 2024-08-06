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

/**
 * Functions
 */

function movePiece(e) {
    let destination = document.elementsFromPoint(e.pageX, e.pageY).find((ele, i) => {
        return ele.classList.contains("square");
    });

    axios.patch('/api/piece/' + this.id, { x: destination.dataset.x, y: destination.dataset.y })
        .then(response => {
            // Preserve move
            console.log(response.data);
            destination.innerHTML = '';
            destination.appendChild(this);
            this.style.position = null;
            this.style.left = null;
            this.style.top = null;
            this.x = destination.dataset.x;
            this.y = destination.dataset.y;
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

function setPieceLocation(piece, x, y) {
    piece.style.left = x - piece.offsetWidth / 2 + 'px';
    piece.style.top = y - piece.offsetHeight / 2 + 'px';
}

function convertEventToLocation(event) {
    setPieceLocation(this, event.pageX, event.pageY);
}
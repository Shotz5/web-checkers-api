import './bootstrap';
import 'axios';

function movePiece(piece, destination) {
    let target = destination.id.split('');
    destination.appendChild(piece);
    piece.style.position = null;
    piece.style.left = null;
    piece.style.top = null;
    console.log(target);
    piece.x = target[0];
    piece.y = target[1];
    axios.patch('/api/board/' + piece.id, piece)
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.log(error);
        });
}

function setPieceLocation(piece, x, y) {
    piece.style.left = x - piece.offsetWidth / 2 + 'px';
    piece.style.top = y - piece.offsetHeight / 2 + 'px';
}

function convertEventToLocation(event) {
    setPieceLocation(this, event.pageX, event.pageY);
}

axios.get('/api/board/create')
    .then(response => {
        response.data.forEach((ele, i) => {
            let domEle = document.getElementById(ele.x + "" + ele.y);
            let newEle = document.createElement("p");
            newEle.id = ele.id;
            newEle.classList.add("piece");
            newEle.classList.add(ele.colour);
            domEle.append(newEle);
            newEle.addEventListener("mousedown", function (e) {
                let piece = this;
                piece.style.position = "absolute";
                document.body.append(piece);

                setPieceLocation(piece, e.pageX, e.pageY);

                piece.addEventListener('mousemove', convertEventToLocation);
                piece.addEventListener('mouseup', function (f) {
                    let destination = document.elementsFromPoint(f.pageX, f.pageY).find((ele, i) => {
                        return ele.classList.contains("square");
                    });
                    movePiece(piece, destination);
                    piece.removeEventListener('mousemove', convertEventToLocation);
                });
            });
        });
    })
    .catch(error => {
        console.log(error);
    });
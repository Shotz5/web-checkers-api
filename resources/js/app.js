import './bootstrap';
import 'axios';

function movePiece(piece, x, y) {
    axios.patch('/api/board/' + piece)
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
                piece.style.zIndex = 1000;
                document.body.append(piece);

                setPieceLocation(piece, e.pageX, e.pageY);

                piece.addEventListener('mousemove', convertEventToLocation);
                piece.addEventListener('mouseup', function (f) {
                    piece.removeEventListener('mousemove', convertEventToLocation);
                });
            });
        });
    })
    .catch(error => {
        console.log(error);
    });
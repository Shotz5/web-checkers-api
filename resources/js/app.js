import './bootstrap';
import 'axios';

function movePiece(e) {
    let destination = document.elementsFromPoint(e.pageX, e.pageY).find((ele, i) => {
        return ele.classList.contains("square");
    });
    destination.appendChild(this);
    this.style.position = null;
    this.style.left = null;
    this.style.top = null;
    this.x = destination.dataset.x;
    this.y = destination.dataset.y;
    axios.patch('/api/piece/' + this.id, this)
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

// axios.get('/api/board/create')
//     .then(response => {
//         response.data.forEach((ele, i) => {
//             let domEle = document.getElementById("board-" + ele.x + ele.y);
//             let newEle = document.createElement("p");

//             newEle.id = ele.id;
//             newEle.classList.add("piece");
//             newEle.classList.add(ele.colour);

//             domEle.append(newEle);

//             newEle.addEventListener("mousedown", function (e) {
//                 let piece = this;
//                 piece.style.position = "absolute";
//                 document.body.append(piece);

//                 setPieceLocation(piece, e.pageX, e.pageY);

//                 piece.addEventListener('mousemove', convertEventToLocation);
//             });
//             newEle.addEventListener('mouseup', movePiece);
//         });
//     })
//     .catch(error => {
//         console.log(error);
//     });
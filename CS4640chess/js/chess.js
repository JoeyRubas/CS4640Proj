let startSquareId = null;
let draggedPiece = null;
let originalParent = null;

function allowDrop(ev) {
  ev.preventDefault();
}

function getImageForPiece(pieceCode) {
  const imgNames = {
    "r": "rook-b", "n": "knight-b", "b": "bishop-b",
    "q": "queen-b", "k": "king-b", "p": "pawn-b",
    "R": "rook-w", "N": "knight-w", "B": "bishop-w",
    "Q": "queen-w", "K": "king-w", "P": "pawn-w"
  };
  return `img/${imgNames[pieceCode]}.svg`;
}


function drag(ev) {
  draggedPiece = ev.target;
  startSquareId = ev.target.parentNode.id;
  originalParent = ev.target.parentNode;
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();

  const targetSquare = ev.target.closest(".square");
  const endSquareId = targetSquare.id;

  const formData = new URLSearchParams();
  formData.append("from", startSquareId);
  formData.append("to", endSquareId);
  formData.append("promotion", "Q");

  fetch("?command=playMove", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {

        const playerTargetSquare = document.getElementById(endSquareId);
        const existingPiece = playerTargetSquare.querySelector(".piece");
        if (existingPiece) {
          existingPiece.remove();
        }
        
       
        if ( data.is_promotion ) {
          console.log("Promotion move detected.");
          const queenImg = document.createElement("img");
          queenImg.src = getImageForPiece( "Q");
          queenImg.id = `piece-${endSquareId}`;
          queenImg.className = "piece";
          queenImg.draggable = true;
          queenImg.ondragstart = drag;
          playerTargetSquare.appendChild(queenImg);
          draggedPiece.remove();
        } else {
          playerTargetSquare.appendChild(draggedPiece);
        }


        const oppFrom = document.getElementById(data.from);
        const oppPiece = oppFrom.querySelector(".piece");

        if (oppPiece) {
          const oppTo = document.getElementById(data.to);
          oppTo.innerHTML = "";

          const oppEndRank = 8 - Math.floor(data.to / 8);
          const oppIsPawn = oppPiece.src.includes("pawn");
          if (oppEndRank === 1 && oppIsPawn) {
            const oppQueenImg = document.createElement("img");
            oppQueenImg.src = getImageForPiece('q');
            oppQueenImg.id = `piece-${data.to}`;
            oppQueenImg.className = "piece";
            oppQueenImg.draggable = true;
            oppQueenImg.ondragstart = drag;
            oppTo.appendChild(oppQueenImg);
          } else {
            oppTo.appendChild(oppPiece);
          }

        }
      } else {
        originalParent.appendChild(draggedPiece);
      }
    })
    .catch(err => {
      originalParent.appendChild(draggedPiece);
    });
}

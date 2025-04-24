let startSquareId = null;
let draggedPiece = null;
let originalParent = null;

function allowDrop(ev) {
  ev.preventDefault();
}

function makeQueen(img, endSquareId) {
  const queenImg = document.createElement("img");
          queenImg.src = `img/${img}.svg`
          queenImg.id = `piece-${endSquareId}`;
          queenImg.className = "piece";
          queenImg.draggable = true;
          queenImg.ondragstart = drag;
  return queenImg;
}


function drag(ev) {
  draggedPiece = ev.target;
  startSquareId = ev.target.parentNode.id;
  originalParent = ev.target.parentNode;
  ev.dataTransfer.setData("text", ev.target.id);
}

function clearHighlights() {
  document.querySelectorAll(".square").forEach(sq => {
    sq.classList.remove("highlight-player-move", "highlight-opponent-move");
  });
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
        console.log("Move successful:", data);

        clearHighlights();

        const playerTargetSquare = document.getElementById(endSquareId);
        const playerStartSquare = document.getElementById(startSquareId);

        playerStartSquare.classList.add("highlight-player-move");
        playerTargetSquare.classList.add("highlight-player-move");

        const existingPiece = playerTargetSquare.querySelector(".piece");
        if (existingPiece) {
          existingPiece.remove();
          console.log("performing capture");
        }

        if (data.is_promotion) {
          console.log("performing promotion");
          const queenImg = makeQueen("queen-w", endSquareId);
          playerTargetSquare.appendChild(queenImg);
          draggedPiece.remove();
        } else {
          console.log("performing normal move");
          playerTargetSquare.appendChild(draggedPiece);
        }

        if (data.opp_move) {
          const oppFrom = document.getElementById(data.from);
          const oppTo = document.getElementById(data.to);

          oppFrom.classList.add("highlight-opponent-move");
          oppTo.classList.add("highlight-opponent-move");

          const oppPiece = oppFrom.querySelector(".piece");
          if (oppPiece) {
            oppTo.innerHTML = "";
            if (data.opponent_is_promotion) {
              const oppQueenImg = makeQueen("queen-b", data.to);
              oppTo.appendChild(oppQueenImg);
              oppPiece.remove();
            } else {
              oppTo.appendChild(oppPiece);
            }
          }
        }

        if (data.game_over) {
          endGame(data.result);
        }

      } else {
        originalParent.appendChild(draggedPiece);
      }
    })
    .catch(err => {
      console.error("Error:", err);
      originalParent.appendChild(draggedPiece);
    });
}


let startSquareId = null;
let draggedPiece = null;
let originalParent = null;

function allowDrop(ev) {
  ev.preventDefault();
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
        playerTargetSquare.appendChild(draggedPiece);

        const oppFrom = document.getElementById(data.from);
        const oppPiece = oppFrom.querySelector(".piece");

        if (oppPiece) {
          const oppTo = document.getElementById(data.to);
          oppTo.innerHTML = ""; 
          oppTo.appendChild(oppPiece);
        }
      } else {
        originalParent.appendChild(draggedPiece);
      }
    })
    .catch(err => {
      originalParent.appendChild(draggedPiece);
    });
}

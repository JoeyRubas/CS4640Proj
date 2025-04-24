function endGame(points) {

    const formData = new URLSearchParams();
    formData.append('result', points);
    fetch('?command=endgame', {
        method: "POST",
        headers: {
        "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                fetch('CS4640chess/templates/GameOver.php')
                    .then(response => response.text())
                    .then(html => {
                        const modal = document.createElement('div');
                        modal.innerHTML = html;
                        document.body.appendChild(modal);
                    });
            }
            else {
                alert("Error: " + data.message);
            }
        });
}



document.addEventListener('DOMContentLoaded', function () {
    const endGameBtn = document.querySelector('a.btn-danger');

    if (endGameBtn) {
        endGameBtn.addEventListener('click', function (e) {
            e.preventDefault();
            endGame(0);
            
    });
    }

    const gameStatus = document.querySelector('div#game-status');
    if (gameStatus) {
        console.log("Game status element found:", gameStatus);
        const statusValue = parseInt(gameStatus.textContent);
        if (statusValue !== -1) {
            endGame(statusValue);
        }
    }
});

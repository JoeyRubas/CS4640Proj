document.addEventListener('DOMContentLoaded', function () {
    const endGameBtn = document.querySelector('a.btn-danger');

    if (endGameBtn) {
        endGameBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('?command=endgame', {
                method: 'POST'
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
        });
    }
});
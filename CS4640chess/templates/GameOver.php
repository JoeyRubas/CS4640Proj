<?php
session_start();
$summary = $_SESSION["game_summary"] ?? ["fen" => "", "difficulty" => "", "points" => 0];
?>

<div id="game-over-modal" class="GO-overlay">
    <div class="GO-content">
        <h2>Game Over</h2>
        <p><strong>FEN:</strong> <?= htmlspecialchars($summary["fen"]) ?></p>
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($summary["difficulty"]) ?></p>
        <p><strong>Points:</strong> <?= htmlspecialchars($summary["points"]) ?></p>
        <button onclick="window.location.href='?command=welcome'" class="btn btn-primary">Back to Welcome</button>
    </div>
</div>
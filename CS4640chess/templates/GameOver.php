<?php
session_start();
$summary = $_SESSION["game_summary"] ?? ["fen" => "", "difficulty" => "", "points" => 0];
?>

<div id="game-over-modal" class="GO-overlay">
    <div class="GO-content">
        <?php if ($summary["points"] == 0): ?>
                <h2>Game Over</h2>
                <p>Sorry, you lost the game. Better luck next time!</p>
            <?php elseif ($summary["points"] == $summary["difficulty"] * 100): ?>
                    <h2>Congratulations!</h2>
                    <p>You won the game!</p>
            <?php else: ?>
                    <h2>Game Over</h2>
                    <p>The Game ended in a Draw</p>
        <?php endif; ?>
        <p><strong>FEN:</strong> <?= htmlspecialchars($summary["fen"]) ?></p>
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($summary["difficulty"]) ?></p>
        <p><strong>Points:</strong> <?= htmlspecialchars($summary["points"]) ?></p>
        <button onclick="window.location.href='?command=welcome'" class="btn btn-primary">Back to Welcome</button>
    </div>
</div>
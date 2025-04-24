<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)">
<meta name="description" content="All files written by pair programming in a study room by Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)">

    <link rel="stylesheet" href="styles.css">

    <title>CS 4640 Chess</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/fontawesome.min.css">
    
  </head>
  <body>
    <div class="background">
      <?php include 'nav.php'; ?>
      <div class="game">
        <div class="board">
          <table>
          <?php include 'board.php'; ?>
            </table>
            <div id="game-status" style="display: none;"><?php echo $result; ?></div>
          </div>
        <div class="info-container">
          <h1 class="p-4 game-info text-black rounded">Bot Difficulty: <span class="badge text-bg-secondary"><?php echo $difficulty; ?></span></h1>
          <h1 class="p-4 game-info text-black rounded"> Move Number: <span class="badge text-bg-secondary"><?php echo $move_number; ?></span></h1>
          <h1 class="p-4 game-info text-black rounded">Evaluation: <span class="badge text-bg-secondary"><?php echo $evaluation; ?></span></h1>
          <h1 class="p-4 game-info text-black rounded">Best Move: <span class="badge text-bg-secondary"><?php echo $best_move; ?></span></h1>
          <form action="?command=review" method="post" style="display: inline;">
              <input type="hidden" name="move" value="<?php echo $move_number - 1; ?>">
              <button type="submit" class="btn btn-danger" <?php echo ($move_number == 0) ? 'disabled' : ''; ?>>Previous Move</button>
          </form>
          <form action="?command=review" method="post" style="display: inline;">
              <input type="hidden" name="move" value="<?php echo $move_number + 1; ?>">
              <button type="submit" class="btn btn-success" <?php echo ($move_number == $total_moves-1) ? 'disabled' : ''; ?>>Next Move</button>
          </form>
          
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>

  </body>
</html>

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
      rel="stylesheet"
  >
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/fontawesome.min.css"
  >
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body>
    <div>
    <?php include 'nav.php'; ?>
    <?php
    function who_won($points)
    {
        if ($points > 0) {
            return "You";
        } elseif ($points < 0) {
            return "Bot";
        } else {
            return "Tie";
        }
    } ?>
      <table id="savedgamestable" class="table table-hover primary-table rounded-4 fs-4 historytable">
        <thead>
          <tr>
            <th scope="col">Game ID</th>
            <th scope="col">Winner</th>
            <th scope="col">   </th>

          </tr>
        </thead>
          <tbody>
          <?php foreach ($games as $index => $game): ?>
                  <tr class="game-summary" style="cursor: pointer;" data-index="<?php echo $index; ?>">
                      <td><?php echo $game['id']; ?></td>
                      <td><?php echo who_won($game['points']); ?></td>
                      <td colspan="2">
                          <i class="fas fa-chevron-down toggle-icon" style="transition: transform 0.3s;"></i>
                      </td>
                  </tr>
                  <tr class="game-details" id="details-<?php echo $index; ?>" style="display: none;">
                      <td colspan="4">
                          <div class="p-3 border rounded gamesum">
                              <strong>Difficulty:</strong> <?php echo $game['bot_difficulty']; ?><br>
                              <strong>Timestamp:</strong> <?php echo $game['modified_at']; ?><br>
                              <form method="post" action="?command=loadGame" class="d-inline">
                                  <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                  <button type="submit" id="reviewgame" class="btn btn-primary btn-sm mt-2">Review Game</button>
                              </form>
                              <form method="post" action="?command=deleteGame" class="d-inline">
                                  <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                  <button type="submit" id="deletegame" class="btn btn-danger btn-sm mt-2">Delete Game</button>
                              </form>
                          </div>
                      </td>
                  </tr>
          <?php endforeach; ?>
          </tbody>
      </table>
      

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="CS4640Chess/js/gameSummary.js"> </script>
    </div>
  </body>
</html>

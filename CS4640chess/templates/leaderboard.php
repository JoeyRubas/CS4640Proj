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
    <div class="background">
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
      <table class="table table-hover primary-table rounded-4 fs-4 historytable">
        <thead>
          <tr>
            <th scope="col">Username</th>
            <th scope="col">Points</th>
            <th scope="col">Most Recent Game</th>

          </tr>
        </thead>
          <tbody>
          <?php foreach ($users as $index => $user): ?>
                  <tr class="game-summary" style="cursor: pointer;" data-index="<?php echo $index; ?>">
                      <td><?php echo $user['name']; ?></td>
                      <td><?php echo $user['points']; ?></td>
                        <td><form method="post" action="?command=loadGame" class="d-inline"></form>
                        <input type="hidden" name="game_id" value="<?php echo $user['game_id']; ?>">
                        <button type="submit" class="btn btn-primary btn-sm mt-2" <?php echo ($user['game_id'] === null) ? 'disabled' : ''; ?>>Review Game</button>
                        </form></td>
          <?php endforeach; ?>
          </tbody>
      </table>
      

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
  </body>
</html>

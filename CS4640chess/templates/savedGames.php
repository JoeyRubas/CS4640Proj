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
  </head>

  <body>
    <div class="background">
    <?php include 'nav.php'; ?>

      <table class="table table-hover primary-table rounded-4 fs-4 historytable">
        <thead>
          <tr>
            <th scope="col">Difficulty</th>
            <th scope="col">Timestamp</th>
            <th scope="col">Load Game</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($games as $game): ?>
            <tr>
              <td><?php echo $game['bot_difficulty']; ?></td>
              <td><?php echo $game['modified_at']; ?></td>
              <td>
                <form method="post" action="?command=loadGame">
                  <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                  <button type="submit" class="btn btn-primary">Load Game</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
      

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
  </body>
</html>

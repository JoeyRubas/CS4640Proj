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
  <script src="CS4640chess/js/endGame.js"></script>
    <script src="CS4640chess/js/chess.js"></script>
    
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
          <h1 class="p-4 game-info text-black rounded">Bot Difficulty: 
            <span class="badge text-bg-secondary">
              <?php echo $_SESSION["difficulty"]; ?>
            </span>
          </h1>
          <h1 class="p-4 game-info text-black rounded"> 
            <img src="img/profilepic.jpg" class="rounded-4 image-fluid pfp" alt="test profile picture"> 
            <?php echo $_SESSION["name"]; ?> 
            <span class="badge text-bg-secondary">
              <?php echo $_SESSION["points"]; ?> 🏆
            </span>
            </h1>
          <a href="?command=endgame" class="btn btn-danger">Resign</a>
          
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>

  </body>
</html>

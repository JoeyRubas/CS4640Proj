<!-- All files written by pair programming in a study room by Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)-->
<!-- Deployment is active at: https://cs4640.cs.virginia.edu/hhx5qj/sprint2/ -->
<?php $theme = $_COOKIE["theme"] ?? "light"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)">
    <meta name="description" content="All files written by pair programming in a study room by Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <body class="<?= htmlspecialchars($theme) ?>">
    <div class="background">
      <?php include 'nav.php'; ?>

      <div class="container mt-5">
        <h1 class="welcome p-4 text-black rounded">
          Welcome back to CS 4640 Chess!
            <div id="tip-container" style="margin-top: 10px; font-style: italic; font-size: medium;"></div>
        </h1>

        <div class="mt-4 rounded-4">
          <img
            src="img/backgroundchess.webp"
            class="img-fluid rounded-4 image-background"
            alt="A chess board"
          >
          <?=$message?>
          <div class="play-bar rounded-4 btn-group">
            <form action="?command=play" method="post">
                <button
                        type="submit"
                        class="btn btn-success fs-1 play-btn">
                    Play
                </button>
                <div class="btn btn-danger play-btn fs-1">
                    Difficulty:
                    <select name="difficulty" class="btn btn-light fs-3" title="difficulty selection">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
            </form>
          </div>
            <form action="?command=welcome" method="post">
                <input type="hidden" name="theme" value="dark">
                <button
                        type="submit"
                        class="btn btn-success fs-1 play-btn">
                    Dark Mode
                </button>
        </div>
      </div>
        </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="CS4640chess/js/tips.js"></script>
  </body>
</html>

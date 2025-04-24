<!-- All files written by pair programming in a study room by Joey Rubas (unn4nf) and Vincent Martinez (hhx5qj)-->
<!-- Deployment is active at: https://cs4640.cs.virginia.edu/hhx5qj/sprint2/ -->

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
  <body>
    <?php include 'nav.php'; ?>
    <?= $message ?>
    <div id="holder">

      <div id="top">
        <div id="top-content">
          <div id="welcome">
            <h1>
              Welcome to Lonely Chess!
            </h1>
            <div id="tip-container" style="margin-top: 10px; font-style: italic; font-size: medium;"></div>
          </div>
        </div>

        <div id="top-image">
          <img src="img/backgroundchess.webp" class="image-background" alt="A chess board">
        </div>
      </div>

      <div id="bottom">

        <div class="play-bar">
          <form action="?command=play" method="post" id="playform">
            <button type="submit" class="play-btn">
              Play
            </button>
            <div id="difficulty">
              Difficulty:
              <select name="difficulty" title="difficulty selection" class="form-select w-auto d-inline-block ms-2">
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

      </div>
      
    </div>

    <script src="CS4640chess/js/tips.js"></script>
  </body>
</html>
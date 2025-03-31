<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Joey Rubas">
    <meta name="description" content="Our Front-Controller Anagrams Game">  
    <title>Anagrams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">       
  </head>
  <body>
    <div class="container" style="margin-top: 15px;">
    <div class="card">
        <div class="card-header">
            <h2>Game Over!</h2>
        </div>
        
        <div class="card-body">
            <h3>Final Score: <?= $score ?></h3>
            
            <h4>Correct Guesses:</h4>
            <?php foreach ($guesses as $guess): ?>
                <p><?= $guess ?></p>
            <?php endforeach; ?>
            <p class="card-text">Incorrect Guesses: <?=$wrong_guesses?></p>
            <p class="card-text">Games Won: <?=$won_games?></p>
              <p class="card-text">Games Played: <?=$played?></p>
              <p class="card-text">Total Score: <?=$total?></p>
              <p class="card-text">High Score: <?=$high?></p>
            

            <p>Thanks for playing!</p>
            <a href="?command=playagain" class="btn btn-danger">Play Again</a>
            <a href="?command=logout" class="btn btn-primary">Log Out</a>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

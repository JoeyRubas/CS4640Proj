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
    <script src="chess.js"></script>
  </head>
  <body>
    <div class="background">
      <?php include 'nav.php'; ?>
      <div class="game">
        <div class="board">
          <table>
          <?php 

function drawSquare($id, $row, $img){
    $img_names = array(
        "r" => "rook-b",
        "n" => "knight-b",
        "b" => "bishop-b",
        "q" => "queen-b",
        "k" => "king-b",
        "p" => "pawn-b",
        "R" => "rook-w",
        "N" => "knight-w",
        "B" => "bishop-w",
        "Q" => "queen-w",
        "K" => "king-w",
        "P" => "pawn-w"
    );

    if (($id + $row) % 2 == 0){
        $color = "light-square";
    }
    else{
        $color = "dark-square";
    }

    echo "<td id = $id ondrop='drop(event)' ondragover='allowDrop(event)' class='square $color'>";
    if ($img != "None"){
      echo "<img src='img/$img_names[$img].svg' id='piece-$id' class='piece' draggable='true' ondragstart='drag(event)'/>";

    }
    echo "</td>";

}


$rows = explode("/", $fen);
$id = 0;
$row_num = 0;
foreach ($rows as $row){
    echo "<tr>";
        foreach (str_split($row) as $piece){
            if (is_numeric($piece)){
                for ($i = 0; $i < $piece; $i++){
                  drawSquare($id, $row_num, "None"); 
                  $id++; 
                }
            }
            else{
                if ($piece == " "){
                    break;
                }
                drawSquare($id, $row_num, $piece);
                $id++;
                }
        }
        echo "</tr>";
        $row_num++;
    }?>
            </table>
          </div>
        <div class="info-container">
          <h1 class="p-4 game-info text-black rounded">Bot Difficulty: <span class="badge text-bg-secondary"><?php echo $difficulty;?></span></h1>
          <h1 class="p-4 game-info text-black rounded"> <img src="img/profilepic.jpg" class="rounded-4 image-fluid pfp" alt="test profile picture"> <?php echo $name;?> <span class="badge text-bg-secondary">250 🏆</span></h1>
          <a href="?command=endgame" class="btn btn-danger">End Game</a>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
  </body>
</html>

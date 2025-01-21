<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="styles.css" />

    <title>CS 4640 Chess</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/fontawesome.min.css"
    />
    <script src="chess.js"></script>
  </head>
  <body>
    <div class="background">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="index.html">CS 4640 Chess</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
              <li class="nav-item">
                <a class="nav-link" href="#">Leaderboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mygames.html">My Games</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

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
                        echo "<img src='img/$img_names[$img].svg' id=' $img $id' class='piece' draggable='true' ondragstart='drag(event)'/>";
                    }
                    echo "</td>";

                }

                $fen = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
                
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
                    }
                    
                
                ?>
            </table>
          </div>
        <div class="info-container">
          <h1 class="p-4 game-info text-black rounded">Bot Difficulty: <span class="badge text-bg-secondary">10</span></h1>
          <h1 class="p-4 game-info text-black rounded">Move : <span class="badge text-bg-secondary">0</span></h1>
          <h1 class="p-4 game-info text-black rounded"> <img src="img/profilepic.jpg" class="rounded-4 image-fluid pfp"> </img> Magnus21 <span class="badge text-bg-secondary">250 🏆</span></h1>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
  </body>
</html>

<?php 

function drawSquare($id, $row, $img, $review){
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
    $ondrop_action = "";
    $drop_action = "";

    if (!$review)
        {
            $ondrop_action = "ondrop='drop(event)' ondragover='allowDrop(event)'";
            $drop_action = "draggable='true' ondragstart='drag(event)'";
        }
    echo "<td id = $id $ondrop_action class='square $color'>";
    if ($img != "None"){
      echo "<img src='img/$img_names[$img].svg' id='piece-$id' $drop_action class='piece'/>";

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
                  drawSquare($id, $row_num, "None", $review); 
                  $id++; 
                }
            }
            else{
                if ($piece == " "){
                    break;
                }
                drawSquare($id, $row_num, $piece, $review);
                $id++;
                }
        }
        echo "</tr>";
        $row_num++;
    }?>
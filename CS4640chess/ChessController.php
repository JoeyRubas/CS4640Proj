

<?php

include_once(__DIR__ . "/../external/chess/src/Chess.php");
include_once(__DIR__ . "/../external/chess/src/Piece.php");
include_once(__DIR__ . "/../external/chess/src/Board.php");
include_once(__DIR__ . "/../external/chess/src/Move.php");
include_once(__DIR__ . "/../external/chess/src/Validation.php");
include_once(__DIR__ . "/../external/chess/src/Entry.php");
include_once(__DIR__ . "/../external/chess/src/History.php");

use PChess\Chess\Chess;
use PChess\Chess\Piece;
use PChess\Chess\Move;
use PChess\Chess\Board;
use PChess\Chess\Validation;
use PChess\Chess\Entry;
use PChess\Chess\History;

class ChessController {


  private $db;

  private $errorMessage = "";

  public function __construct($input) {
    session_start();

    $this->input = $input;
    $this->db = new Database();

  }

  public function run() {
    $command = "welcome";
    if (isset($this->input["command"]) && (
      $this->input["command"] == "login" || isset($_SESSION["name"])))
      $command = $this->input["command"];
      $message = "";
    
    

    if (!isset($_SESSION["user_id"]) && $command != "login"){
      $command = "loginPage";
    }

    switch($command) {
      case "logout":
        $this->logout();
        $message = "<div class='alert alert-success'>Logged out successfully!</div>";
      case "loginPage":
        $this->showLogin($message);
        return;
      case "login": 
        $this->login();
        break;
      case "play":
        $this->play();
        break;
      case "savedGames":
        $this -> savedGames();
        break;
      case "loadGame":
        $this -> loadGame();
        break;
      case "playMove":
        $this -> makeMove();
        break;
      case "endgame": 
        $this -> processEnd();
        break;
      case "welcome":
      default:
        $this->showWelcome($message);
        break;
    }
  }

public function refreshGame() {
    $user_id = $_SESSION["user_id"];
    $name = $_SESSION["name"]; 
    $email = $_SESSION["email"];
    $difficulty = $_SESSION["difficulty"];
    $game = $_SESSION["game"];
    $turn = $game->turn;
    $fen = $game->fen();
    $_SESSION["fen"] = $fen;
    if ($turn == "b"){
      $this -> makeOpponentMove();
    }

    include("CS4640chess/templates/game.php");
  }

public function play(){
  if (isset($_SESSION["game"]) && $_SESSION["game"] != null){
    return $this -> refreshGame();
  }
  
  
  if (isset($_POST["difficulty"])){
        $_SESSION["difficulty"] = $_POST["difficulty"];
        $game = new Chess();
        $_SESSION["game"] = $game;
        $_SESSION["fen"] = $game->fen();
        $_SESSION["loaded_id"] = null;
        return $this->refreshGame();
      }
  
  else {
    $message = "<p class='alert alert-danger'>Please select a difficulty level!</p>";
    $this->showWelcome($message);
  }
}

public function numToSquare($num){
  $letter = chr( 104 - (($num-1) % 8));
  $number = (int)ceil($num / 8);
  return $letter . $number;
}

public function squareToNum($square){
  $letter = $square[0]; 
  $number = (int)substr($square, 1)-1;
  $fileIndex = ord($letter)-97;
  $num = ($number * 8) + (8-$fileIndex);

  return 64-$num;
}


public function makeMove(){
  $game = $_SESSION["game"];
  $from = $this -> numToSquare(64-$_POST["from"]);
  $to = $this -> numToSquare(64-$_POST["to"]);
  $res = $game ->move(["from" => $from, "to" => $to, "promotion" => false]);
  if ($res == null){
    header('Content-Type: application/json');
    echo json_encode(["success" => false]);
    return;
  }

  $fen = $game -> fen();
  $_SESSION["fen"] = $fen;

  $res = $this -> makeOpponentMove();
  $opp_from = $res["from"];
  $opp_to = $res["to"];
  header('Content-Type: application/json');
    echo json_encode(["success" => true,
                      "from" => $this -> squareToNum($opp_from),
                      "to" => $this -> squareToNum($opp_to)]);
     return;
}

public function makeOpponentMove(){
  $game = $_SESSION["game"];
  $legal_moves = $game->moves();
  $game->move($legal_moves[0]->san);
  return ["from"=>$legal_moves[0]-> from, "to"=>$legal_moves[0]->to];
}

public function login() {

  if (isset($_POST["username"]) && isset($_POST["email"]) &&
    isset($_POST["password"]) && !empty($_POST["password"]) &&
    !empty($_POST["username"]) && !empty($_POST["email"])) {
      $username = $_POST["username"];
      if (!preg_match('/chess/i', $username)) {
        $message = "<p class='alert alter-danger'> Username must contain the word chess!";
        $this->showLogin($message);
        return;
      }
    

    $results = $this->db->query("select * from chess_users where email = $1;", $_POST["email"]);
   
    if (empty($results)) {

      $this->db->query("insert into chess_users (name, email, password) values ($1, $2, $3);",
        $_POST["username"], $_POST["email"], 
        password_hash($_POST["password"], PASSWORD_DEFAULT));
      $results = $this->db->query("select * from chess_users where email = $1;", $_POST["email"]);
      $user_id = $results[0]["id"];
      $_SESSION["user_id"] = $user_id;
      $_SESSION["name"] = $_POST["username"];
      $_SESSION["email"] = $_POST["email"];
      
      $message = "<p class='alert alert-success'> New account created!</p>";
      $this -> showWelcome($message);
      return;
      
    } 
    
    else {
      $user_id = $results[0]["id"];
      $_SESSION["user_id"] = $results[0]["id"];
      $hashed_password = $results[0]["password"];
      $correct = password_verify($_POST["password"], $hashed_password);
      if ($correct) {
        $_SESSION["name"] = $_POST["username"];
        $_SESSION["email"] = $_POST["email"];
        $message = "<p class='alert alert-success'>Login successful!</p>";
        $this->showWelcome($message);
        return;    
        } else {
       $message = "<p class='alert alert-danger'>Incorrect password!</p>"; 
       $this->showLogin($message);
       return;
      }
      
    }
    $message = "<p class='alert alter-danger'> Missing password, name or email";
    $this->showLogin($message);
    return;
  }

}


public function logout() {
  session_destroy();
}
 
public function savedGames(){
  $games = $this -> db -> query("SELECT * from chess_games WHERE user_id = $1", $_SESSION["user_id"]);
  include("CS4640chess/templates/savedGames.php");
}

public function loadGame(){
  $results = $this -> db -> query ("SELECT * from chess_games WHERE id=$1", $_POST["game_id"]);
  if (!isset($results)){
    return savedGames();
  }
  $game = $results[0];
  $fen = $game["pgn"];
  $_SESSION["fen"] = $fen;
  $_SESSION["game"] = new Chess($fen);
  $_SESSION["loaded_id"] = $_POST["game_id"];
  return $this -> refreshGame();
}
  
  public function showWelcome($message="") {
    include("CS4640chess/templates/welcome.php");
  }

    public function showLogin($message = "") {
    include("CS4640chess/templates/login.php");
  }

  public function processEnd(){
    $game = $_SESSION["game"];
    $fen = $game->fen();



    $user_id = $_SESSION["user_id"];
    $difficulty = $_SESSION["difficulty"];
    $points = 0; 
  if ($_SESSION["loaded_id"] === null) {
    $this->db->query(
    "INSERT INTO chess_games (bot_difficulty, pgn, points, user_id, modified_at) VALUES ($1, $2, $3, $4, NOW());",
    $difficulty, $fen, $points, $user_id
    );
  }
  else {
    $this->db->query(
    "UPDATE chess_games SET bot_difficulty = $1, pgn = $2, points = $3, modified_at = NOW() WHERE id = $4;",
    $difficulty, $fen, $points, $_SESSION["loaded_id"]
    );
  }

    $_SESSION["loaded_id"] = null;
    $_SESSION["game"] = null;
    $_SESSION["fen"] = null;
    
    return $this->showWelcome();
  }

}
 
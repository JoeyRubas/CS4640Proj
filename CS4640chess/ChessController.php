

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


class ChessController
{


    private $db;

    private $errorMessage = "";
    private $input = null;

    public function __construct($input)
    {
        session_start();

        $this->input = $input;
        $this->db = new Database();
    }

    public function run()
    {
        $command = "welcome";
        $message = "";
        if (
            isset($this->input["command"]) && (
                $this->input["command"] == "login" || 
                $this->input["command"] == "registerPage" ||
                $this->input["command"] == "register" ||
                isset($_SESSION["name"]))
        )
        {
            $command = $this->input["command"];
        
        }
        else {
            $command = "loginPage";
        }
            


        switch ($command) {
            case "logout":
                $this->logout();
                $message = "<div class='alert alert-success'>Logged out successfully!</div>";
            case "loginPage":
                $this->showLogin($message);
                return;
            case "login":
                $this->login();
                break;
            case "register":
                $this->register();
                break;
            case "registerPage":
                $this->showRegister($message);
                break;
            case "play":
                $this->play();
                break;
            case "savedGames":
                $this->savedGames();
                break;
            case "leaderboard":
                $this->leaderboard();
                break;
            case "loadGame":
                $this->loadGame();
                break;
            case "review":
                $this->reviewGame();
                break;
            case "playMove":
                $this->makeMove();
                break;
            case "endgame": {
                $this->processEnd();
                break;
            }
            case "gameoverpopup": {
                $this->showGameOver();
                break;
            }
            case "deleteGame":
                $this->deleteGame();
            case "welcome":
            default:
                $this->showWelcome($message);
                break;
        }
    }


    public function refreshGame()
    {
        $game = $_SESSION["game"];
        $turn = $game->turn;

        $checkmate = $game->inCheckmate();
        $draw = $game->inDraw();
        $result = -1;
        if ($draw) {
            $result = 0.5;
        } else if ($checkmate && $turn == "w") {
            $result = 0;
        } else if ($checkmate && $turn == "b") {
            $result = 1;
        }
        $game_over = $draw || $checkmate;

        if ($turn == "b" && !$game_over) {
            $this->makeOpponentMove();
            $_SESSION["move"]++;
        }

        $fen = $this->disableEnPassant($game->fen());
        $_SESSION["fen"] = $fen;
        $_SESSION["fen_list"][$_SESSION["move"]] = $fen;
        $review = false;
        include("CS4640chess/templates/game.php");
    }

    public function play()
    {
        if (isset($_SESSION["game"]) && $_SESSION["game"] != null) {
            return $this->refreshGame();
        }

        if (isset($_POST["difficulty"])) {
            $_SESSION["difficulty"] = $_POST["difficulty"];
            $game = new Chess("rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w - - 0 1");
            $_SESSION["game"] = $game;
            $_SESSION["fen"] = $this->disableEnPassant($game->fen());
            $_SESSION["move"] = 0;
            $_SESSION["fen_list"] = array();
            $_SESSION["loaded_id"] = null;
            return $this->refreshGame();
        } else {
            $message = "<p class='alert alert-danger'>Please select a difficulty level!</p>";
            $this->showWelcome($message);
        }
    }

    public function numToSquare($num)
    {
        $letter = chr(104 - (($num - 1) % 8));
        $number = (int) ceil($num / 8);
        return $letter . $number;
    }

    public function squareToNum($square)
    {
        $letter = $square[0];
        $number = (int) substr($square, 1) - 1;
        $fileIndex = ord($letter) - 97;
        $num = ($number * 8) + (8 - $fileIndex);

        return 64 - $num;
    }

    public function makeMove()
    {
        $extra_data = [];
        $game = $_SESSION["game"];

        $game_over = false;
        $result = -1;
        $opp_from = -1;
        $opp_to = -1;
        $opp_promotion = false;
        $make_opponent_move = true;

        $from = $this->numToSquare(64 - $_POST["from"]);
        $to = $this->numToSquare(64 - $_POST["to"]);

        $isPromotion = false;
        $from_rank = intval(substr($from, 1, 1));
        $to_rank = intval(substr($to, 1, 1));
        $piece = $game->get($from);


        $extra_data["to_rank"] = $to_rank;
        $extra_data["from"] = $from;
        $extra_data["piece"] = $piece;

        if ($piece == "P" && $to_rank === 8) {
            $isPromotion = true;
            $extra_data["promotion"] = "Q";
        }

        $res = $game->move([
            "from" => $from,
            "to" => $to,
            "promotion" => $isPromotion ? 'q' : false
        ]);

        if ($res == null) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false]);
            return;
        }

        $fen = $this->disableEnPassant($game->fen());
        $_SESSION["fen"] = $fen;
        $_SESSION["move"]++;
        $_SESSION["fen_list"][$_SESSION["move"]] = $fen;

        $draw = $game->inDraw();
        $checkmate = $game->inCheckmate();
        if ($draw || $checkmate) {
            $game_over = true;
            $result = $draw ? .5 : 1;
            $make_opponent_move = false;
        }

        if ($make_opponent_move) {
            $res = $this->makeOpponentMove();
            $opp_from = $this->squareToNum($res["from"]);
            $opp_to = $this->squareToNum($res["to"]);
            $draw = $game->inDraw();
            $checkmate = $game->inCheckmate();
            $opp_promotion = $res["promotion"] != false;

            if ($draw || $checkmate) {
                $game_over = true;
                $result = $draw ? .5 : 0;
            }
            $fen = $this->disableEnPassant($game->fen());
            $_SESSION["fen"] = $fen;
            $_SESSION["move"]++;
            $_SESSION["fen_list"][$_SESSION["move"]] = $fen;
        }

        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "from" => $opp_from,
            "to" => $opp_to,
            "is_promotion" => $isPromotion,
            "opp_move" => $make_opponent_move,
            "opponent_is_promotion" => $opp_promotion,
            "game_over" => $game_over,
            "result" => $result,
        ]);
        return;
    }

    public function disableEnPassant($fen)
    {
        $parts = explode(' ', $fen);
        $parts[3] = '-';
        return implode(' ', $parts);
    }

    public function randMove()
    {
        $game = $_SESSION["game"];
        $moves = $game->moves();
        $move = $moves[random_int(0, count($moves) - 1)];
        $game->move($move->san);
        return [
            "from" => $move->from,
            "to" => $move->to,
            "promotion" => $move->promotion
        ];
    }

    public function queryChessApi($fen)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://chess-api.com/v1');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['fen' => $fen]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }


    public function realMove()
    {
        $game = $_SESSION["game"];
        $fen = $this->disableEnPassant($game->fen());

        $response = $this->queryChessApi($fen);
        if (!isset($response['from']) || !isset($response['to'])) {
            throw new Exception("Invalid move response from API: " . json_encode($response));
        }
        $from = $response["from"];
        $to = $response["to"];
        $promotion = !empty($response["isPromotion"]) ? "q" : false;

        $move = ["from" => $from, "to" => $to, "promotion" => $promotion];
        if ($promotion) {
            $move["promotion"] = $promotion;
        }

        $game->move($move);
        return $move;
    }

    public function makeOpponentMove()
    {
        $difficulty = $_SESSION["difficulty"];
        $probability = 20 + 12 * $difficulty;
        $rand = rand(1, 100);

        if ($rand <= $probability) {
            return $this->realMove();
        } else {
            return $this->randMove();
        }
    }

    public function login()
    {
        if (
            isset($_POST["username"]) &&
            !empty($_POST["username"]) &&
            isset($_POST["password"]) && 
            !empty($_POST["password"])
        ) {

            $results = $this->db->query("select * from chess_users where name = $1;", $_POST["username"]);
            if (empty($results)) {
                $message = "<p class='alert alert-danger'> Accounts with these credentials does not exist</p>";
                $this -> showLogin($message);
                return;

            } else {
                $hashed_password = $results[0]["password"];
                $correct = password_verify($_POST["password"], $hashed_password);
                if ($correct) {
                    $_SESSION["user_id"] = $results[0]["id"];
                    $_SESSION["points"] = $results[0]["points"];
                    $_SESSION["name"] = $_POST["username"];
                    
                    $message = "<p class='alert alert-success'>Login successful!</p>";
                    $this->showWelcome($message);
                    return;
                } else {
                    $message = "<p class='alert alert-danger'>Incorrect password!</p>";
                    $this->showLogin($message);
                    return;
                }
            }
        }
        $message = "<p class='alert alter-danger'> Missing username or password!</p>";
        $this->showLogin($message);
        return;
    }

    public function register(){
        if (
            isset($_POST["username"]) && isset($_POST["email"]) &&
            isset($_POST["password"]) && !empty($_POST["password"]) &&
            !empty($_POST["username"]) && !empty($_POST["email"])
        ) {
            $username = $_POST["username"];
            if (!preg_match('/chess/i', $username)) {
                $message = "<p class='alert alter-danger'> Username must contain the word chess!";
                $this->showRegister($message);
                return;
            }

            $results = $this->db->query("select * from chess_users where name = $1;", $_POST["username"]);
            if (empty($results)) {

                $this->db->query(
                    "insert into chess_users (name, email, password) values ($1, $2, $3);",
                    $_POST["username"],
                    $_POST["email"],
                    password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                $results = $this->db->query("select * from chess_users where email = $1;", $_POST["email"]);
                $user_id = $results[0]["id"];
                $_SESSION["user_id"] = $user_id;
                $_SESSION["name"] = $_POST["username"];
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["points"] = 0;

                $message = "<p class='alert alert-success'> New account created!</p>";
                header("Location: ?command=welcome");
                return;
            } else {
                $message = "<p class='alert alert-danger'> An account with this username already exists! Please login instead</p>";
                $this->showLogin($message);
                return;
            }
    }

        $message = "<p class='alert alter-danger'> Missing username, email or password!</p>";
        $this->showLogin($message);
        return;
}


    public function logout()
    {
        $_SESSION["user_id"] = null;
        session_destroy();
    }

    public function savedGames()
    {
        $games = $this->db->query("SELECT * from chess_games WHERE user_id = $1", $_SESSION["user_id"]);
        include("CS4640chess/templates/savedGames.php");
    }

    public function loadGame()
    {
        $results = $this->db->query("SELECT * from chess_games WHERE id=$1", $_POST["game_id"]);
        if (!isset($results)) {
            return $this->savedGames();
        }

        $results = $results[0];
        $_SESSION["review_difficulty"] = $results["bot_difficulty"];
        $_SESSION["review_list"] = json_decode($results['pgn'], true);
        $_SESSION["cached_evals"] = array();
        return $this->reviewGame(0);
    }

    public function reviewGame($move_number = -1)
    {
        if ($move_number == -1) {
            $move_number = $_POST["move"];
        }

        $review = true;
        $fen = $_SESSION["review_list"][$move_number];
        $difficulty = $_SESSION["review_difficulty"];

        if (isset($_SESSION["cached_evals"][$move_number])) {

            $response = $_SESSION["cached_evals"][$move_number];
        } else {
            $response = $this->queryChessApi($fen);
            $_SESSION["cached_evals"][$move_number] = $response;
        }

        $total_moves = count($_SESSION["review_list"]);

        $evaluation = $response["eval"];
        $best_move = explode(":", $response["text"])[0];
        include("CS4640chess/templates/gameReview.php");
    }

    public function deleteGame()
    {
        $this->db->query("DELETE FROM chess_games WHERE id = $1 AND user_id = $2", $_POST["game_id"], $_SESSION["user_id"]);
        header("Location: ?command=savedGames");
        return $this->savedGames();
    }


    public function showWelcome($message = "")
    {
        if (isset($_POST["theme"])) {
            setcookie("theme", $_POST["theme"], time() + (86400 * 30), "/");
            $_SESSION["theme"] = $_POST["theme"];
        }
        include("CS4640chess/templates/welcome.php");
    }

    public function showGameOver()
    {
        include("CS4640chess/templates/GameOver.php");
    }
    public function showLogin($message = "")
    {
        include("CS4640chess/templates/login.php");
    }

    public function showRegister($message = "")
    {
        include("CS4640chess/templates/register.php");
    }

    public function processEnd()
    {
        $result = $_POST["result"];
        $game = $_SESSION["game"];
        $fen = $this->disableEnPassant($game->fen());
        $flattenedFenList = json_encode($_SESSION["fen_list"]);
        $user_id = $_SESSION["user_id"];
        $difficulty = $_SESSION["difficulty"];
        $points = $result * $difficulty * 100;
        $this->db->query(
            "INSERT INTO chess_games (bot_difficulty, pgn, points, user_id, modified_at) VALUES ($1, $2, $3, $4, NOW());",
            $difficulty,
            $flattenedFenList,
            $points,
            $user_id
        );
        $this->db->query(
            "UPDATE chess_users SET points = points + $1 WHERE id = $2;",
            $points,
            $user_id
        );
        $_SESSION["points"] += $points;

        $_SESSION["game_summary"] = [
            "fen" => $fen,
            "difficulty" => $difficulty,
            "points" => $points
        ];
        $_SESSION["loaded_id"] = null;
        $_SESSION["game"] = null;

        $_SESSION["fen"] = null;
        header('Content-Type: application/json');
        echo json_encode(["status" => "ok"]);

        exit();
    }


    public function leaderboard()
    {
        $result = $this->db->query(
            "SELECT u.id, u.name, u.points, 
                  (SELECT g.id 
                   FROM chess_games g 
                   WHERE g.user_id = u.id 
                   ORDER BY g.modified_at DESC 
                   LIMIT 1) as game_id
           FROM chess_users u
           ORDER BY u.points DESC
           LIMIT 25;"
        );

        $users = [];
        foreach ($result as $row) {
            $users[] = [
                "id" => $row["id"],
                "name" => $row["name"],
                "points" => $row["points"],
                "game_id" => $row["game_id"]
            ];
        }

        include("templates/leaderboard.php");
    }
}

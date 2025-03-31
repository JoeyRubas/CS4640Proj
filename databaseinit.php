<?php
    $host = "db";
    $port = "5432";
    $database = "example";
    $user = "localuser";
    $password = "cs4640LocalUser!"; 

    // $host = "localhost";
    // $port = 5432;
    // $user = "unn4nf";
    // $password = "EkHMv41_d3Ty";
    // $database = "unn4nf";

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if (!$dbHandle)  {
        die("An error occurred connecting to the database");
    } else {
        echo "Connected to the database successfully.<br>";
    }

    $res = pg_query($dbHandle, "DROP TABLE IF EXISTS chess_games;");
    if (!$res) {
        echo "Error dropping table 'chess_games': " . pg_last_error($dbHandle) . "<br>";
    }


    $res = pg_query($dbHandle, "DROP TABLE IF EXISTS chess_users;");
    if (!$res) {
        echo "Error dropping table 'chess_users': " . pg_last_error($dbHandle) . "<br>";
    }
    

    $res = pg_query($dbHandle, "CREATE TABLE chess_users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        points INT DEFAULT 0
    );");

    if ($res) {
        echo "Table 'chess_users' created successfully.<br>";
    } else {
        echo "Error creating table 'chess_users': " . pg_last_error($dbHandle) . "<br>";
    }

    $res = pg_query($dbHandle, "CREATE TABLE chess_games (
        id SERIAL PRIMARY KEY,
        bot_difficulty VARCHAR(50) NOT NULL,
        pgn TEXT NOT NULL,
        points INT DEFAULT 0,
        user_id INT REFERENCES chess_users(id),
        modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );");
    
    if ($res) {
        echo "Table 'chess_games' created successfully.<br>";
    } else {
        echo "Error creating table 'chess_games': " . pg_last_error($dbHandle) . "<br>";
    }
    ?>

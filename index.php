<?php

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name
spl_autoload_register(function ($classname) {
    $path = "CS4640chess/$classname.php";
    if (file_exists($path)) {
        include $path;
    }
});

function checkDatabaseSetup() {
    $host = "db";
    $port = "5432";
    $database = "example";
    $user = "localuser";
    $password = "cs4640LocalUser!";

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if (!$dbHandle) {
        return false;
    }

    // Check if our tables exist
    $res = pg_query($dbHandle, "SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'chess_users'
    );");

    $tablesExist = pg_fetch_result($res, 0, 0) === 't';
    pg_close($dbHandle);

    return $tablesExist;
}

function initializeDatabase() {
    include 'databaseinit.php';
}

// Check if database is set up, if not, initialize it
if (!checkDatabaseSetup()) {
    initializeDatabase();
}

$chessController = new ChessController($_GET);

$chessController->run();
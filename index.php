<?php

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name.  All our classes will be in a directory
// that Apache does not serve publicly.  They will be in C:/xampp/htdocs/, which
// is our src/ directory in Docker.
spl_autoload_register(function ($classname) {
        $path = "CS4640chess/$classname.php";
        if (file_exists($path)) {
            include $path;
        }
});

// CS4640 server
// public files: public_html
// private files: anything OUTSIDE of public_html
//     create a "private" next to public_html
//     include "/students/mst3k/students/mst3k/private"
//
//     if I created "private/anagramsgame"
//     include "/students/mst3k/students/mst3k/private/anagramsgame/$classname.php";:


// Other global things that we need to do

// Instantiate the front controller
$anagrams = new ChessController($_GET);

// Run the controller
$anagrams->run();


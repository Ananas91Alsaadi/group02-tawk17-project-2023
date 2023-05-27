<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";

class movieController extends ControllerBase
{

    public function handleRequest()
    {
        $this->requireAuth();

       $this->viewPage("movies");
    }
}
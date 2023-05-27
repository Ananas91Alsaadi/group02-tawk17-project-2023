<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";
require_once __DIR__ . "/../../business-logic/commentsService.php";

class singleMovieController extends ControllerBase
{

    public function handleRequest()
    {
        $this->model['id'] = $this->path_parts[2];

        if ($this->path_count == 3) {
            //$this->showOne();
            $this->showAll($this->path_parts[2]);
    
        }
    

       $this->viewPage("movie");
    }

    private function showAll($movie_id)
    {
        //$this->requireAuth();
       $comments = commentsService::getcommentsByMovie($movie_id);////////////////
/*
        if ($this->user->user_role === "admin") {
            $comments = commentsService::getAllcomments();
        } else {
            $comments = commentsService::getcommentsByUser($this->user->user_id);
        }
*/
        // $this->model is used for sending data to the view
        $this->model['data'] = $comments;

    }

}
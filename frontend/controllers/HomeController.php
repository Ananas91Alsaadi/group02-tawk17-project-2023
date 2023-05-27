<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";


class HomeController extends ControllerBase
{

    public function handleRequest($request_info)
    {
        if ($request_info == "not_found") {
            $this->notFound();
        } else {
            $this->showAll();

            $this->viewPage("home");
        }
    }
    private function showAll()
    {
       $comments = commentsService::getAllcomments();////////////////
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

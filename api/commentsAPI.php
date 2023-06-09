<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/RestAPI.php";
require_once __DIR__ . "/../business-logic/commentsService.php";
require_once __DIR__ . "/../movieDB-api/movieDBAPI.php";


class commentsAPI extends RestAPI
{

    // Handles the request by calling the appropriate member function
    public function handleRequest()
    {

        // GET: /api/comments
        if ($this->method == "GET" && $this->path_count == 2) {
            $this->getAll();
        }

        // GET: /api/comments/{id}
        else if ($this->path_count == 3 && $this->method == "GET") {
            $this->getById($this->path_parts[2]);
        }
        // GET: /api/comments/autocomplete/query

        else if ($this->path_count == 4 && $this->method == "GET" && $this->path_parts[2] == "autocomplete") {
            $this->getAutocomplete($this->path_parts[3]);
        }

        // POST: /api/comments
        else if ($this->path_count == 2 && $this->method == "POST") {
            $this->postOne();
        }

     

        // PUT: /api/comments/{id}
        else if ($this->path_count == 3 && $this->method == "PUT") {
            $this->putOne($this->path_parts[2]);
        }

        // DELETE: /api/comments/{id}
        else if ($this->path_count == 3 && $this->method == "DELETE") {
            $this->deleteOne($this->path_parts[2]);
        }

        // If none of our ifs are true, we should respond with "not found"
        else {
            $this->notFound();
        }
    }

    private function getAll()
    {
        $this->requireAuth();

        if ($this->user->user_role === "admin") {
            $comments = commentsService::getAllcomments();
        } else {
            //$comments = commentsService::getcommentsByUser($this->user->user_id);
        }


        $this->sendJson($comments);
    }


    private function getById($id)
    {
        $this->requireAuth();

        $comment = commentsService::getcommentById($id);

        if (!$comment) {
            $this->notFound();
        }

        if ($this->user->user_role !== "admin" || $comment->user_id !== $this->user->user_id) {
            $this->forbidden();
        }

        $this->sendJson($comment);
    }


    private function postOne()
    {
        $this->requireAuth();

        $comment = new commentModel();

        $comment->movie_id = $this->body["movie_id"];
        $comment->rate = $this->body["rate"];
        $comment->comment_text = $this->body["comment_text"];

        // Admins can connect any user to the comment
        if($this->user->user_role === "admin"){
            //$comment->user_id = $this->body["user_id"];
        }

        // Regular users can only add comments to themself
        else{
           // $comment->user_id = $this->user->user_id;
        }

        $success = commentsService::savecomment($comment);

        if ($success) {
            $this->created();
        } else {
            $this->error();
        }
    }

    
    private function putOne($id)
    {
        $this->requireAuth();

        $comment = new commentModel();

        $comment->movie_id = $this->body["movie_id"];
        $comment->rate = $this->body["rate"];
        $comment->comment_text = $this->body["comment_text"];

        // Admins can connect any user to the comment
        if($this->user->user_role === "admin"){
           // $comment->user_id = $this->body["user_id"];
        }

        // Regular users can only add comments to themself
        else{
           // $comment->user_id = $this->user->user_id;
        }

        $success = commentsService::updatecommentById($id, $comment);

        if ($success) {
            $this->ok();
        } else {
            $this->error();
        }
    }

    // Deletes the comment with the specified ID in the DB
    private function deleteOne($id)
    {
        // only admins can delete comments
        $this->requireAuth(["admin"]);

        $comment = commentsService::getcommentById($id);

        if ($comment == null) {
            $this->notFound();
        }

        $success = commentsService::deletecommentById($id);

        if ($success) {
            $this->noContent();
        } else {
            $this->error();
        }
    }

    private function getAutocomplete($x)
    {
        // only admins can delete comments
       // $this->requireAuth();

        $movies = movieDBAPI::getTopMovieByName($x);
        
        if ($movies == null) {
            return "Not found";
        }
       // var_dump($movies);
        $this->sendJson($movies);

       // return $movies;


    }
}

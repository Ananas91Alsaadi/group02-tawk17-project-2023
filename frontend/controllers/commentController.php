<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";
require_once __DIR__ . "/../../business-logic/commentsService.php";


class commentController extends ControllerBase
{

    public function handleRequest()
    {

        // Check for POST method before checking any of the GET-routes
        if ($this->method == "POST") {
            $this->handlePost();
        }


        // GET: /home/comments
        if ($this->path_count == 2) {

            $this->showAll($this->path_parts[1]);
        }


        // GET: /home/comments/new
        else if ($this->path_count == 3 && $this->path_parts[2] == "new") {
            $this->showNewcommentForm();
        }


        // GET: /home/comments/{id}
        else if ($this->path_count == 3) {
            //$this->showOne();
            $this->showAll($this->path_parts[2]);

        }


        // GET: /home/comments/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->showEditForm();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }



    // Gets all comments and shows them in the index view
    private function showAll($movie_id)
    {
        $this->requireAuth();

        //$this->createcomment($movie_id);///////////////////

       $comments = commentsService::getcommentsByUserAndMovie($movie_id, $this->user->user_name);////////////////
        echo $this->user->user_name;
       if (count($comments)<1) {
        $this->createcomment($movie_id,$this->user->user_name);
        $this->showAll($movie_id);
    } 
       /*      
        if ($this->user->user_role === "admin") {
            $comments = commentsService::getAllcomments();
        } else {
            $comments = commentsService::getcommentsByUser($this->user->user_id);
        }
*/
        // $this->model is used for sending data to the view
        $this->model = $comments;


        $this->viewPage("comments/index");
    }



    // Gets one comment and shows the in the single view
    private function showOne()
    {
        // Get the comment with the ID from the URL
        $comment = $this->getcomment();

        // $this->model is used for sending data to the view
        $this->model = $comment;

        // Shows the view file comments/single.php
        $this->viewPage("comments/single");
    }



    // Gets one and shows it in the edit view
    private function showEditForm()
    {
        $this->requireAuth();

        // Get the comment with the ID from the URL
        $comment = $this->getcomment();

        // $this->model is used for sending data to the view
        $this->model = $comment;

        // Shows the view file comments/edit.php
        $this->viewPage("comments/edit");
    }




    private function showNewcommentForm()
    {
        $this->requireAuth();

        // Shows the view file comments/new.php
        $this->viewPage("comments/new");
    }



    // Gets one comment based on the id in the url
    private function getcomment()
    {
        $this->requireAuth();

        // Get the comment with the specified ID
        $id = $this->path_parts[2];

        $comment = commentsService::getcommentById($id);

        if (!$comment) {
            $this->notFound();
        }
        /*echo $comment->user_name . $this->user->user_name;
        if ($this->user->user_role !== "admin" && $comment->user_name !== $this->user->user_name) {
            $this->forbidden();
        }*/

        return $comment;
    }


    // handle all post requests for comments in one place
    private function handlePost()
    {
        // POST: /home/comments
        if ($this->path_count == 2) {
            //$this->createcomment();
        }

        // POST: /home/comment/{id}/edit
        else if ($this->path_count == 4 && $this->path_parts[3] == "edit") {
            $this->updatecomment();
        }

        // POST: /home/comment/{id}/delete
        else if ($this->path_count == 4 && $this->path_parts[3] == "delete") {
            $this->deletecomment();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }


    // Create a comment with data from the URL and body
    private function createcomment($movie_id,$user_name)
    {
        $this->requireAuth();

        $comment = new commentModel();

        // Get updated properties from the body
        $comment->movie_id = $movie_id;
        $comment->rate = 0;
        $comment->comment_text = '';

            $comment->user_name = $user_name;
            echo $this->user->user_name;

        // Save the comment
        $success = commentsService::savecomment($comment);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            //$this->redirect($this->home . "/comments");
        } else {
            $this->error();
        }
    }


    // Update a comment with data from the URL and body
    private function updatecomment()
    {
        $this->requireAuth();

        $comment = new commentModel();

        // Get ID from the URL
        $id = $this->path_parts[2];

        $existing_comment = commentsService::getcommentById($id);
        // Get updated properties from the body
        $comment->movie_id = $existing_comment->movie_id;
        $comment->rate = $this->body["rate"];
        $comment->comment_text = $this->body["comment_text"];
        $comment->user_name = $existing_comment->user_name;



        $success = commentsService::updatecommentById($id, $comment);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . "/movie/".$comment->movie_id );

        } else {
            $this->error();
        }
    }


    // Delete a comment with data from the URL
    private function deletecomment()
    {

                // Get ID from the URL
                $id = $this->path_parts[2];

        $this->requireAuth(["admin"]);
        $comment = commentsService::getcommentById($id);

        $movie_id= $comment->movie_id;


        // Delete the comment
        $success = commentsService::deletecommentById($id);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . '/movie/' . $movie_id );
        } else {
            $this->error();
        }
    }
}

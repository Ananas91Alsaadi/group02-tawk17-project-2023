<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../data-access/commentsDatabase.php";

class commentsService{

    public static function getcommentById($id){
        $comments_database = new commentsDatabase();

        $comment = $comments_database->getOne($id);

        return $comment;
    }
    

    public static function getAllcomments(){
        $comments_database = new commentsDatabase();

        $comments = $comments_database->getAll();

        return $comments;
    }
    

    public static function getcommentsByUserAndMovie($movie_id, $user_name){
        $comments_database = new commentsDatabase();

        $comments = $comments_database->getByUserId($movie_id, $user_name);

        return $comments;
    }
    public static function getcommentsByMovie($movie_id){
        $comments_database = new commentsDatabase();

        $comments = $comments_database->getByMovieId($movie_id);

        return $comments;
    }
    
    public static function savecomment(commentModel $comment){
        $comments_database = new commentsDatabase();

        $success = $comments_database->insert($comment);

        return $success;
    }

    
    public static function updatecommentById($comment_id, commentModel $comment){
        $comment_database = new commentsDatabase();

        $success = $comment_database->updateById($comment_id, $comment);

        return $success;
    }

    
    public static function deletecommentById($comment_id){
        $comment_database = new commentsDatabase();

        $success = $comment_database->deleteById($comment_id);

        return $success;
    }
}


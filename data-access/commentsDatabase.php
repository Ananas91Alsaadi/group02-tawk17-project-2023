<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}


require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/commentModel.php";

class commentsDatabase extends Database
{
    private $table_name = "comments";
    private $id_name = "comment_id";


    public function getOne($comment_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->id_name, $comment_id);

        $comment = $result->fetch_object("commentModel");

        return $comment;
    }



    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $comments = [];

        while ($comment = $result->fetch_object("commentModel")) {
            $comments[] = $comment;
        }

        return $comments;
    }


    public function getByUserId($movie_id, $user_name)
    {
        $query = "SELECT * FROM comments WHERE user_name = ? AND movie_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("si", $user_name,$movie_id);
        $stmt->execute();

        $result = $stmt->get_result();

        $comments = [];

        while ($comment = $result->fetch_object("commentModel")) {
            $comments[] = $comment;
        }

        return $comments;
    }
    public function getByMovieId($movie_id)
    {
        $query = "SELECT * FROM comments WHERE movie_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $movie_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $comments = [];

        while ($comment = $result->fetch_object("commentModel")) {
            $comments[] = $comment;
        }

        return $comments;
    }


    public function insert(commentModel $comment)
    {
        $query = "INSERT INTO comments (movie_id, rate, comment_text, user_name) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("iiss", $comment->movie_id, $comment->rate, $comment->comment_text, $comment->user_name);

        $success = $stmt->execute();

        return $success;
    }


     
    public function updateById($comment_id, commentModel $comment)
    {
        $query = "UPDATE comments SET movie_id=?, rate=?, comment_text=?, user_name=? WHERE comment_id=?;";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("iissi", $comment->movie_id, $comment->rate, $comment->comment_text, $comment->user_name, $comment_id);

        $success = $stmt->execute();

        return $success;
    }

    public function deleteById($comment_id)
    {
        $success = $this->deleteOneRowByIdFromTable($this->table_name, $this->id_name, $comment_id);

        return $success;
    }
}

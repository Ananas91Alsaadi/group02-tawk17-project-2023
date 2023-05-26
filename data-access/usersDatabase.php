<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Use "require_once" to load the files needed for the class

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/UserModel.php";

class UsersDatabase extends Database
{
    private $table_name = "users";
    private $id_name = "user_id";

    // Get one user by using the inherited function getOneRowByIdFromTable
    // Never send the password hash unless needed for authentication
    public function getByUsername($user_name)
    {
        $user = $this->getByUsernameWithPassword($user_name);

        // Never send the password hash unless needed for authentication
        unset($user->password_hash);

        // Return the UserModel object or null if no user was found
        return $user;
    }

    // Get one user by using the inherited function getOneRowByIdFromTable
    // Never send the password hash unless needed for authentication
    public function getByUsernameWithPassword($user_name)
    {
        // Define SQL query to retrieve user data by username
        $query = "SELECT * FROM users WHERE user_name = ?";

        // Prepare the query statement
        $stmt = $this->conn->prepare($query);

        // Bind the username parameter to the prepared statement
        $stmt->bind_param("s", $user_name);

        // Execute the query
        $stmt->execute();

        // Get the result of the query as a mysqli_result object
        $result = $stmt->get_result();

        // Fetch the user data as a UserModel object
        $user = $result->fetch_object("UserModel");

        // Return the UserModel object or null if no user was found
        return $user;
    }

    // Get one user by using the inherited function getOneRowByIdFromTable
    // Never send the password hash unless needed for authentication
    public function getByIdWithPassword($user_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->id_name, $user_id);

        $user = $result->fetch_object("UserModel");

        return $user;
    }

    // Get one user by using the inherited function getOneRowByIdFromTable
    public function getOne($user_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->id_name, $user_id);

        $user = $result->fetch_object("UserModel");

        // Never send the password hash unless needed for authentication
        unset($user->password_hash);

        return $user;
    }


    // Get all users by using the inherited function getAllRowsFromTable
    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $users = [];

        while ($user = $result->fetch_object("UserModel")) {
            $users[] = $user;

            // Never send the password hash unless needed for authentication
            unset($user->password_hash);
        }

        return $users;
    }

    // Create one by creating a query and using the inherited $this->conn 
    public function insert(UserModel $user)
    {
        echo "done insert";
        
        $query = "INSERT INTO users (user_name, password_hash, user_role, profile_pic_url) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssss", $user->user_name, $user->password_hash, $user->user_role, $user->profile_pic_url);

        $success = $stmt->execute();

        return $success;
    }

    // Update one by creating a query and using the inherited $this->conn 
    public function updateById($user_id, UserModel $user)
    {
        $query = "UPDATE users SET user_name=?, user_role=?, password_hash=? WHERE user_id=?;";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sssi", $user->user_name, $user->user_role, $user->password_hash, $user_id);

        $success = $stmt->execute();

        return $success;
    }

    // Update one by creating a query and using the inherited $this->conn 
    public function updatePasswordById($user_id, $password_hash)
    {
        $query = "UPDATE users SET password_hash=? WHERE user_id=?;";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("si", $password_hash, $user_id);

        $success = $stmt->execute();

        return $success;
    }

    // Delete one by using the inherited function deleteOneRowByIdFromTable
    public function deleteByUsername($user_id)
    {
        
        $successComments = $this->deleteAllRowsByIdFromTable("comments", "user_name", $user_id);

        $success = $this->deleteOneRowByIdFromTable($this->table_name, "user_name", $user_id);

        

        return ($success && $successComments);
    }
}

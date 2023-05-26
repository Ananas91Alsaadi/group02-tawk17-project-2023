<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for users-table in database

class commentModel{
    public $comment_id; //comment_id
    public $movie_id; //product_name
    public $user_name;
    public $rate; //price
    public $comment_text; //comment_time
}
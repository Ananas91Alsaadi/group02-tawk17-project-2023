<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for users-table in database

class UserModel{
    public $user_id;
    public $user_name;
    public $password_hash;
    public $user_role; // Don't use 'role': https://www.sqlstyle.guide/
    public $profile_pic_url; ////////////////////////delete
}
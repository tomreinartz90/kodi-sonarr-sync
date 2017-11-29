<?php
// If you installed via composer, just use this code to requrie autoloader on the top of your projects.
require 'vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;

/**
 * Created by PhpStorm.
 * User: t.reinartz
 * Date: 29-11-2017
 * Time: 12:12
 */
class KodiDB {

    private $database;
    /**
     * KodiDB constructor.
     */
    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'name',
            'server' => 'localhost',
            'username' => 'your_username',
            'password' => 'your_password'
        ]);
    }

    function getRecentlyWatchedEpisodes(){
        return $this->database->query("SELECT * FROM episode_view WHERE lastPlayed >= DATE_SUB(CURRENT_DATE(),INTERVAL 1 DAY) AND resumeTimeInSeconds == NULL");
    }
}
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
    public function __construct($dbname, $dbServer, $dbUser, $dbPass)
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => $dbname,
            'server' => $dbServer,
            'username' => $dbUser,
            'password' => $dbPass
        ]);
    }

    function getRecentlyWatchedEpisodesPerSeries(){
        $recentlyWatched = $this->database->query("SELECT strTitle, c12 as season, c13 as episode, idEpisode as id FROM episode_view WHERE lastPlayed >= DATE_SUB(CURRENT_DATE(),INTERVAL 1 DAY) and playCount > 0")->fetchAll();
        $episodesPerSeries = array();
        foreach($recentlyWatched as $key => $item)
        {
            $episodesPerSeries[$item['strTitle']][$item['id']] = $item;
        }
        return ksort($episodesPerSeries, SORT_NUMERIC);
    }
}
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
    private $daysAgo = 500;
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
        $recentlyWatched = $this->database->query("SELECT  strTitle as series, c12 as season, c13 as episode, idEpisode as id FROM episode_view WHERE lastPlayed >= DATE_SUB(CURRENT_DATE(),INTERVAL $this->daysAgo DAY) and playCount > 0")->fetchAll();
//        $recentlyWatched = $this->database->query("SELECT strTitle, c12 as season, c13 as episode, idEpisode as id FROM episode_view WHERE playCount > 0")->fetchAll();
        $episodesPerSeries = array();
        foreach($recentlyWatched as $key => $item)
        {
            $episodesPerSeries[$item['series']][$item['id']] = $item;
        }
        return $episodesPerSeries;
    }

    function getRecentlyWatchedSeries(){
        $mappedSeries = array();
        $series = $this->database->query("SELECT DISTINCT(strTitle) as series FROM episode_view WHERE lastPlayed >= DATE_SUB(CURRENT_DATE(),INTERVAL $this->daysAgo DAY) and playCount > 0")->fetchAll();
        foreach ($series as $item) {
            array_push($mappedSeries, $item['series']);
        }
        return $mappedSeries;
    }
}
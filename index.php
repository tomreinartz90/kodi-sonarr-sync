<?php
/**
 * Created by PhpStorm.
 * User: t.reinartz
 * Date: 29-11-2017
 * Time: 12:49
 */
include_once "KodiDB.php";
include_once "SonarrApi.php";

$kodi = new KodiDB('MyVideos107', 'thuis.tomreinartz.com','xbmc', 'xbmc');
$sonarr = new SonarrApi('https://thuis.tomreinartz.com/sonarr', 'aa9838e7d4444602849061ca1a6bffa7');


//group episodes per series
$episodesPerSeries = $kodi->getRecentlyWatchedEpisodesPerSeries();

//loop over watched episodes
//print_r($episodesPerSeries);
$sonarrSeries = $sonarr->getSeries();
var_dump($sonarrSeries);
//foreach ($sonarrSeries as $series) {
//print_r($series);

//}
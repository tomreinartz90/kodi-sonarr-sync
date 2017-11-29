<?php
/**
 * Created by PhpStorm.
 * User: t.reinartz
 * Date: 29-11-2017
 * Time: 12:49
 */
include_once "KodiDB.php";
include_once "SonarrApi.php";

$kodi = new KodiDB('MyVideos107', '192.168.1.8','xbmc', 'xbmc');
$sonarr = new SonarrApi('192.168.1.100', 'aa9838e7d4444602849061ca1a6bffa7');


//group episodes per series
$episodesPerSeries = $kodi->getRecentlyWatchedEpisodesPerSeries();

//loop over watched episodes
//print_r($episodesPerSeries);
$sonarrSeries = $sonarr->getSeries();
var_dump($sonarrSeries);
//foreach ($sonarrSeries as $series) {
//print_r($series);

//}
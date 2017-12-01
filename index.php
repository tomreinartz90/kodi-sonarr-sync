<?php
/**
 * Created by PhpStorm.
 * User: t.reinartz
 * Date: 29-11-2017
 * Time: 12:49
 */
include_once "KodiDB.php";
include_once "SonarrApi.php";

$kodi = new KodiDB('MyVideos107', '192.168.1.8', 'xbmc', 'xbmc');
$sonarr = new SonarrApi('192.168.1.100:8989', 'aa9838e7d4444602849061ca1a6bffa7');

//group episodes per series
$series = $kodi->getRecentlyWatchedSeries();
$sonarrSeries = $sonarr->getSeries();
if ($series != false && $sonarrSeries != false) {
    $watchedEpisodesPerSeries = $kodi->getRecentlyWatchedEpisodesPerSeries();

    echo("Starting sync for: " . json_encode($series));
    //get the seriesIds
    $sonarrSeriesIds = array();
    foreach ($series as $show) {
        $foundShow = null;
        echo $show;
        foreach ($sonarrSeries as $sonarrShow) {
            if ($show == $sonarrShow['title']) {
                $sonarrSeriesIds[$show] = $sonarrShow['id'];
            }
        }
    }


    //run index per series
    foreach ($sonarrSeriesIds as $series => $seriesId) {
        echo "Running sync for Show: $series \n";
        $markAsUnMonitored = array();
        $episodes = $sonarr->getEpisodesForSeries($seriesId);
        $watchedEpisodes = $watchedEpisodesPerSeries[$series];
        //check sonarr episodes
        foreach ($episodes as $episode) {
            //only check the monitored episodes
            if ($episode['monitored'] === true) {
                foreach ($watchedEpisodes as $episodeId => $watchedEpisode) {
                    //add to markAsWatched when season and episodenumber match
                    if ($episode['seasonNumber'] == $watchedEpisode['season'] && $episode['episodeNumber'] == $watchedEpisode['episode']) {
                        array_push($markAsUnMonitored, $episode);
                    }
                }
            }
        }

        echo "Marking " . count($markAsUnMonitored) . " Episodes as unWatched \n";
        foreach ($markAsUnMonitored as $episode) {
            $episode['monitored'] = false;
            $sonarr->updateEpisode($episode['id'], $episode);
            echo "Season " . $episode['seasonNumber'] . ", Episode " . $episode['episodeNumber'] . "\n";
        }
    }

} else {
    echo "No need to sync episodes\n";
}

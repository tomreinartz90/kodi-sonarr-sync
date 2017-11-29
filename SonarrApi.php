<?php

/**
 * Created by PhpStorm.
 * User: t.reinartz
 * Date: 29-11-2017
 * Time: 12:27
 */
class SonarrApi
{


    /**
     * SonarrApi constructor.
     */
    public function __construct($sonarrUrl, $sonarrApi)
    {
        $this->sonarrUrl = $sonarrUrl;
        $this->sonarrApi = $sonarrApi;
    }

    function getEpisodesForSeries($seriesId)
    {
        return http_get("$this->sonarrUrl/api/episode?apikey=$this->sonarrApi&seriesId=$seriesId");
    }

    function updateEpisode($episodeId, $episode)
    {
        return http_put_data("$this->sonarrUrl/api/episode/$episodeId?apikey=$this->sonarrApi", json_encode($episode));
    }

    function getSeries()
    {
        return http_get("$this->sonarrUrl/api/series?apikey=$this->sonarrApi");
    }
}
<?php

require_once "RestApi.php";

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
    public function __construct($sonarrUrl, $apikey)
    {
        $this->sonarrUrl = $sonarrUrl;
        $this->apikey = $apikey;
        $this->http = new RestApi();
    }

    function getEpisodesForSeries($seriesId)
    {
        return $this->http->get("$this->sonarrUrl/api/episode?apikey=$this->apikey&seriesId=$seriesId");
    }

    function updateEpisode($episodeId, $episode)
    {
        return $this->http->put("$this->sonarrUrl/api/episode/$episodeId?apikey=$this->apikey", json_encode($episode));
    }

    function getSeries()
    {
        return $this->http->get("$this->sonarrUrl/api/series?apikey=$this->apikey");
    }
}
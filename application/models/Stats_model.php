<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Stats_model extends CI_Model
{
    public $ipaddress;
    public $Country;
    public $CountryCode;
    public $City;
    public $Region;
    public $Latitude;
    public $Longitude;
    public $Timezone;
    public $ContinentCode;
    public $ContinentName;
    public $CurrencyCode;
    public $datetimerecord;
    public $view;

//    private $table = 'tbl_statistics';

    public function insertStat(): ?int
    {
        $stats = get_object_vars($this);
        $this->db->trans_start();
        $this->db->insert('tbl_statistics', $stats);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id ? $insert_id : null;
    }

    public function getIpInfo(): object
    {
        return @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $this->ipaddress));
    }

    public function setObject(object $ipInfo): object
    {
        $this->Country = $ipInfo->geoplugin_countryName;
        $this->CountryCode = $ipInfo->geoplugin_countryCode;
        $this->City = $ipInfo->geoplugin_city;
        $this->Region = $ipInfo->geoplugin_region;
        $this->Latitude = $ipInfo->geoplugin_latitude;
        $this->Longitude = $ipInfo->geoplugin_longitude;
        $this->Timezone = $ipInfo->geoplugin_timezone;
        $this->ContinentCode = $ipInfo->geoplugin_continentCode;
        $this->ContinentName = $ipInfo->geoplugin_continentName;
        $this->CurrencyCode = $ipInfo->geoplugin_currencyCode;
        $this->datetimerecord = date("Y-m-d#h:i:s");
        return $this;
    }   
        
}

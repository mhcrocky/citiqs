<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_country_model extends CI_Model {

    public function getCountryEuropeZone($countryCode) {
        $this->db->select('europezone');
        $this->db->from('tbl_dhl_countries');
        $this->db->where("countrycode", $countryCode);
        $query = $this->db->get();
        return $query->result();
    }

}

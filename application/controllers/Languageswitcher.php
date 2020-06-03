<?php
declare(strict_types=1);

if ( ! defined('BASEPATH')) exit('Direct access allowed');

class Languageswitcher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('language', array('controller'=>''));
		$this->load->helper('cookie');
    }

    public function switchLang(string $language = ""): void
    {
        $language = ($language !== "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
		$this->session->set_userdata('site_lang_selected', $language); // set switch for selection otherwise every page goes back to default.
		// we should write this also in a cookie and store the cookie for the next time
		// Cookies no loinger accepted so we need to do this in a session
		// and store it in de table profiles later on
		set_cookie('language', $language, 60 * 60 * 24 * 365);
        redirect($_SERVER['HTTP_REFERER']);
//		header("Refresh:0");
        exit();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use SpryngApiHttpPhp\Client;
use SpryngApiHttpPhp\Exception\InvalidRequestException;

class Sms
{
    // https://www.spryng.be/en/developers/http-api/
    public function send($mobilenumber, $message)
    {
        require_once(FCPATH . 'vendor/autoload.php');
        $spryng = new Client('peter@appao.nl', 'N@ld@rt01@!', 'tiqs');

        try
        {
            $mobilenumber = ltrim($mobilenumber,"+");
            $mobilenumber = ltrim($mobilenumber,"0");
            $mobilenumber = ltrim($mobilenumber,"00");
            $spryng->sms->send($mobilenumber, $message, array(
                    'route' => '2032',
                    'allowlong' => true)
            );
        }
        catch (InvalidRequestException $e)
        {
            // echo $e->getMessage();
            return (FALSE);
        }

        return (TRUE);
    }
}

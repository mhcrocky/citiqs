<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Landingpage_helper
    {

        public static function getTemplateString(array $order, string $landingPage): ?string
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $config['landingPageFolder'] = FCPATH . 'application' . DIRECTORY_SEPARATOR . 'landing_pages' . DIRECTORY_SEPARATOR;

            $templteFile  = $CI->config->item('landingPageFolder') . DIRECTORY_SEPARATOR;
            $templteFile .= $landingPage . '.' . $CI->config->item('landingTemplateExt');

            // TIQS TO DO => replace tags with data from order for template, this is for testing
            return file_exists($templteFile) ? file_get_contents($templteFile) : null;
        }

    }

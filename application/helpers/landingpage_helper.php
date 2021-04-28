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

            if (!file_exists($templteFile)) return null;
            $content = file_get_contents($templteFile);

            $content = str_replace(
                ['[orderId]', '[orderAmount]', '[buyerName]', '[buyerEmail]'],
                [$order['orderId'], $order['orderAmount'], $order['buyerUserName'], $order['buyerEmail']],
                $content
            );

            return $content;
        }

        public static function getTicketingTemplateString(array $reservations, string $landingPage): ?string
        {
            $CI =& get_instance();
            $CI->load->config('custom');

            $config['landingPageFolder'] = FCPATH . 'application' . DIRECTORY_SEPARATOR . 'landing_pages' . DIRECTORY_SEPARATOR;

            $templteFile  = $CI->config->item('landingPageFolder') . DIRECTORY_SEPARATOR;
            $templteFile .= $landingPage . '.' . $CI->config->item('landingTemplateExt');

            if (!file_exists($templteFile)) return null;
            $content = file_get_contents($templteFile);

            foreach($reservations as $reservation){
                $content = str_replace(
                    ['[transactionId]', '[price]', '[buyerName]', '[buyerEmail]'],
                    [$reservation->TransactionID, $reservation->price, $reservation->name, $reservation->email],
                    $content
                );
            }
            

            return $content;
        }

    }

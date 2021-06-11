<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    Class Language_helper
    {

        public static function getLanguage(int $vendorId): string
        {
            $language = '';
            if ($vendorId === 46243) {
                $language = 'fr';
            }

            return $language;
        }
    }

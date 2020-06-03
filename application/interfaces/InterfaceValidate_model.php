<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Interface InterfaceValidate_model
    {
        public function insertValidate(array $data): bool;
        public function updateValidate(array $data): bool;
    }
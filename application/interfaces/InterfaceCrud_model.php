<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Interface InterfaceCrud_model
    {
        public function create(): bool;
        public function read(array $what, array $where): ?array;
        public function update(): bool;
        public function delete(): bool;
    }
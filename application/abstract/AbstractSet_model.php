<?php
    declare(strict_types=1);

    require_once APPPATH . 'abstract/AbstractCrud_model.php';

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Abstract Class AbstractSet_model extends AbstractCrud_model
    {
        abstract protected function setValueType(string $property, &$value): void;

        private function getPublicPropertiesNames(): array
        {
            $reflect = new ReflectionClass($this);
            $publics = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
            $publics = array_map(function($el) {
                return $el->name;
            }, $publics);
            return $publics;
        }

        public function setObjectId(int $value): object
        {
            $this->id = $value;
            return $this;
        }

        public function setObjectFromArray(array $data): object
        {
            $publics = $this->getPublicPropertiesNames();
            foreach ($data as $property => $value) {
                if (in_array($property, $publics)) {
                    $this->setValueType($property, $value);
                    $this->{$property} = $value;
                }
            }
            return $this;
        }

        public function setObject(array $what = []): ?object
        {
            $find = (empty($what)) ? '*' : implode(',', $what);
            $data = $this->read([$find], ['id=' => $this->id]);
            if ($data) {
                $data = reset($data);
                $this->setObjectFromArray($data);
                return $this;
            }
            return null;
        }

        public function setProperty(string $property, $value): object
        {
            $this->setValueType($property, $value);
            $this->{$property} = $value;
            return $this;
        }
    }
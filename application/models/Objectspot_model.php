<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Objectspot_model extends AbstractSet_model implements InterfaceCrud_model
    {
        public $id;
        public $userId;
        public $objectTypeId;
        public $objectName;
        public $country;
        public $city;
        public $zipCode;
        public $address;
        public $startTime;
        public $endTime;
        public $startDate;
        public $endDate;
        public $workingDays;

        private $table = 'tbl_spot_objects';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'userId' || $property === 'objectTypeId') {
                $value = intval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertUserObject(object $user): bool
        {
            $object = $this->prepareObjectFromUser($user);
            return $this->setObjectFromArray($object)->create();
        }

        public function updateSpotObject($objectId, $data)
        {
            $this->db->where('id',$objectId);
            return $this->db->update($this->table,$data);
        }

        public function getUsersObjects(int $userId): ?array
        {
            return $this->read(['*'], ['userId' => $userId]);
        }

        private function prepareObjectFromUser(object $user): array
        {
            return [
                'userId' => $user->id,
                'objectTypeId' => $user->business_type_id,
                'objectName' => $user->username,
                'country' => $user->country,
                'city' => $user->city,
                'zipCode' => $user->zipcode,
                'address' => $user->address,
            ];
        }

        public function fetch(int $userId = 0): ?array
        {
            $where =  ($this->id) ? ['tbl_spot_objects.id=' => $this->id] : ['tbl_spot_objects.userId=' => $userId];
            $objects = $this->read(
                ['tbl_spot_objects.*, tbl_business_types.busineess_type'],
                $where,
                [
                    ['tbl_business_types', 'ON tbl_spot_objects.objectTypeId = tbl_business_types.id', 'INNER'],
                ]
            );
            if ($objects) {
                $objects = array_map(function($object){
                    if (isset($object['workingDays'])) {
                        $object['workingDays'] = unserialize($object['workingDays']);
                    }
                    return $object;
                }, $objects);
            }
            return $objects;
        }

        public function saveSpotObject($data){
            $spotObjectExists = $this->db->select('*')->from($this->table)->where('userId',$data['userId'])->get();
            if($spotObjectExists->num_rows() > 0){
                 $this->db->where('userId', $data['userId']);
                 return $this->db->update($this->table,$data);
            }
            
            return $this->db->insert($this->table, $data);
        }
    }
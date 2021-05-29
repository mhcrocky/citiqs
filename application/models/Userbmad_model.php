<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Userbmad_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {

        public $id;
        public $userId;
        public $name;
        public $isBlocked;
        public $latitude;
        public $longitude;
        public $sexualOrientation;
        public $gender;
        public $dateOfBirth;
        public $phoneCountryCode;
        public $phoneNumber;
        public $maxDistance;
        public $lastMsgTime;
        public $ageRangeMin;
        public $ageRangeMax;
        public $imagesUrl;
        public $isOnline;
        public $lastSeen;

        private $table = 'tbl_users_bmad';

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'userId' || $property === 'maxDistance') {
                $value = intval($value);
            }

            if ($property === 'latitude' || $property === 'longitude') {
                $value = floatval($value);
            }

            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['userId']) && isset($data['name'])) {
                return $this->updateValidate($data);
            }
            return false;
        }

        public function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
            if (isset($data['name']) && !Validate_data_helper::validateStringImproved($data['name'], 2)) return false;
            if (isset($data['isBlocked']) && !($data['isBlocked'] === '1' || $data['isBlocked'] === '0')) return false;
            if (isset($data['latitude']) && !Validate_data_helper::validateFloat($data['latitude'])) return false;
            if (isset($data['longitude']) && !Validate_data_helper::validateFloat($data['longitude'])) return false;
            if (isset($data['sexualOrientation']) && !Validate_data_helper::validateStringImproved($data['sexualOrientation'])) return false;
            if (isset($data['gender']) && !Validate_data_helper::validateStringImproved($data['gender'])) return false;
            if (isset($data['dateOfBirth']) && !Validate_data_helper::validateDate($data['dateOfBirth'])) return false;
            if (isset($data['phoneCountryCode']) && !Validate_data_helper::validateMobileNumber($data['phoneCountryCode'])) return false;
            if (isset($data['phoneNumber']) && !Validate_data_helper::validateMobileNumber($data['phoneNumber'])) return false;
            if (isset($data['maxDistance']) && !Validate_data_helper::validateInteger($data['maxDistance'])) return false;
            if (isset($data['lastMsgTime']) && !Validate_data_helper::validateDate($data['lastMsgTime'])) return false;
            if (isset($data['ageRangeMin']) && !Validate_data_helper::validateInteger($data['ageRangeMin'])) return false;
            if (isset($data['ageRangeMax']) && !Validate_data_helper::validateInteger($data['ageRangeMax'])) return false;
            if (isset($data['imagesUrl']) && !Validate_data_helper::validateStringImproved($data['imagesUrl'])) return false;
            if (isset($data['isOnline']) && !($data['isOnline'] === '1' || $data['isOnline'] === '0')) return false;            
            if (isset($data['lastSeen']) && !Validate_data_helper::validateDate($data['lastSeen'])) return false;

            return true;
        }

        /**
         * insertBmadUser function
         *
         * Method inserts user
         *
         * @access public
         * @param array $user Parametar is required and must be an array
         * @return boolean
         */
        public function insertBmadUser(array $user): bool
        {
            return $this->setObjectFromArray($user)->create();
        }

        /**
         * updateBmadUser function
         *
         * Method updates user
         *
         * @access public
         * @param integer $id Parametar is required and must be an integer
         * @param array $user Parametar is required and must be an array
         * @return boolean
         */
        public function updateBmadUser(int $id, array $user): bool
        {
            return $this->setObjectId($id)->setObjectFromArray($user)->update();
        }

    }

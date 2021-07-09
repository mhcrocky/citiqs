<?php
declare(strict_types=1);

require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
require_once APPPATH . 'abstract/AbstractSet_model.php';

if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Userex_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
{
    public $id;
    public $userId;

    public $isBlocked;
    public $isOnline;

    public $dateOfBirth;
    public $sexualOrientation;
    public $gender;

    public $maxDistance;
    public $ageRangeMin;
    public $ageRangeMax;
    public $imagesUrl;

    public $lastMsgTime;
    public $lastSeen;

    private $table = 'tbl_users_extended';

    protected function setValueType(string $property,  &$value): void
    {
        $this->load->helper('validate_data_helper');

        if (!Validate_data_helper::validateNumber($value)) return;

        if (
            $property === 'id'
            || $property === 'userId'
            || $property === 'maxDistance'
            || $property === 'ageRangeMin'
            || $property === 'ageRangeMax'
        ) {
            $value = intval($value);
        }

        return;
    }

    protected function getThisTable(): string
    {
        return $this->table;
    }

    public function insertValidate(array $data): bool
    {
        if (isset($data['userId'])) {
            return $this->updateValidate($data);
        }
        return false;
    }

    public function updateValidate(array $data): bool
    {
        if (!count($data)) return false;

        if (isset($data['userId']) && !Validate_data_helper::validateInteger($data['userId'])) return false;
        if (isset($data['isBlocked']) && !($data['isBlocked'] === '1' || $data['isBlocked'] === '0')) return false;
        if (isset($data['isOnline']) && !($data['isOnline'] === '1' || $data['isOnline'] === '0')) return false;
        if (isset($data['dateOfBirth']) && !Validate_data_helper::validateDate($data['dateOfBirth'])) return false;
        if (isset($data['sexualOrientation']) && !Validate_data_helper::validateStringImproved($data['sexualOrientation'])) return false;
        if (isset($data['gender']) && !Validate_data_helper::validateStringImproved($data['gender'])) return false;
        if (isset($data['maxDistance']) && !Validate_data_helper::validateInteger($data['maxDistance'])) return false;
        if (isset($data['ageRangeMin']) && !Validate_data_helper::validateInteger($data['ageRangeMin'])) return false;
        if (isset($data['ageRangeMax']) && !Validate_data_helper::validateInteger($data['ageRangeMax'])) return false;
        if (isset($data['imagesUrl']) && !Validate_data_helper::validateStringImproved($data['imagesUrl'])) return false;
        if (isset($data['lastMsgTime']) && !Validate_data_helper::validateDate($data['lastMsgTime'])) return false;
        if (isset($data['lastSeen']) && !Validate_data_helper::validateDate($data['lastSeen'])) return false;

        return true;
    }

    public function setIdFromUserId(): ?Userex_model
    {
        $id = $this->readImproved([
            'what' => [$this->table . '.id'],
            'where' => [
                $this->table . '.userId' => $this->userId
            ]
        ]);

        if (empty($id)) return null;

        $this->id = intval($id[0]['id']);
        return $this;
    }

    public function getUserEx(): ?array
    {
        if ($this->id) {
            $where = [
                $this->table . '.id' => $this->id
            ];
        } elseif ($this->userId)  {
            $where = [
                $this->table . '.userId' => $this->userId
            ];
        }

        if (!isset($where)) return null;

        $user = $this->readImproved([
            'what' => [$this->table . '.*'],
            'where' => $where
        ]);

        return is_null($user) ? null : reset($user);

    }

}

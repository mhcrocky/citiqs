<?php
declare(strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
require_once APPPATH . 'abstract/AbstractSet_model.php';

class Api_model  extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
{

    public $id;
    public $userid;
    public $apikey;
    public $access;
    public $name;

    private $table = 'tbl_APIkeys';

    protected function setValueType(string $property,  &$value): void
    {
        $this->load->helper('validate_data_helper');
        if (!Validate_data_helper::validateNumber($value)) return;

        if ($property === 'id' || $property === 'userid') {
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
        if (isset($data['userid']) && isset($data['apikey']) && isset($data['name'])) {
            return $this->updateValidate($data);
        }
        return false;
    }

    public function updateValidate(array $data): bool
    {
        if (!count($data)) return false;
        if (isset($data['userid']) && !Validate_data_helper::validateInteger($data['userid'])) return false;
        if (isset($data['apikey']) && !Validate_data_helper::validateString($data['apikey'])) return false;
        if (isset($data['access']) && !($data['access'] === '1' || $data['access'] === '0')) return false;
        if (isset($data['name']) && !Validate_data_helper::validateString($data['name'])) return false;

        return true;
    }

    public function getAllItems($userId) {
        $this->db->select(''
                . 'tbl_label.code as itemCode, '
                . 'tbl_label.descript as itemDesc, '
                . 'tbl_label.categoryid as itemCatId, '
                . 'tbl_label.image as itemImage, '
                . 'tbl_category.description as itemCatDesc');
        $this->db->from('tbl_label');
        $this->db->join('tbl_category', 'tbl_category.id = tbl_label.categoryid');
        $this->db->where('userid', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserByIdAndApiKey($userId, $apiKey) {
        $this->db->select('userid, apikey, access');
        $this->db->from('tbl_APIkeys');
        $this->db->where('userid', $userId);
        $this->db->where('apikey', $apiKey);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUserNameById($userId) {
        $this->db->select('username');
        $this->db->from('tbl_user');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function getItemByDescription($description, $userId) {
        $this->db->select('code, descript, categoryid, image');
        $this->db->from('tbl_label');
        $this->db->where('userid', $userId);
        $this->db->like('descript', $description);
        $query = $this->db->get();
        return $query->result();
    }

    public function userAuthentication(string $apiKey): bool
    {
        $this->db->select('id');
        $this->db->from('tbl_APIkeys');
        $this->db->where('apikey', $apiKey);
        $result = $this->db->get();
        return $result->result() ? true : false;
    }

    public function getDeliveryOrders($buyerId){
        $this->db->select('*')
        ->from('tbl_shop_orders')
        ->where(array('buyerId' => $buyerId,'serviceTypeId' => 2));
        $result = $this->db->get();
        return $result->result_array();
    }

    public function insertApiUser(int $userId, string $name): array
    {
        $this->load->helper('utility_helper');

        $insert = [
            'userid' => $userId,
            'apikey' => Utility_helper::shuffleBigStringRandom(32),
            'access' => '0',
            'name' => $name
        ];

        return $this->setObjectFromArray($insert)->create() ? $insert : $this->insertApiUser($userId);
    }

    public function getUser(): ?array
    {
        if ($this->apikey) {
            $where = [$this->table . '.apikey = ' => $this->apikey];
        }

        if ($this->userid) {
            $where = [$this->table . '.userid = ' => $this->userid];
        }

        $result = $this->readImproved([
            'what' => ['*'],
            'where' => $where
        ]);

        if (!$result) return null;

        $result = reset($result);
        return $result;
    }

    public function getUsers(): ?array
    {

        $where = [$this->table . '.userid = ' => $this->userid];

        $result = $this->readImproved([
            'what' => ['*'],
            'where' => $where
        ]);

        if (!$result) return null;

        return $result;
    }
}

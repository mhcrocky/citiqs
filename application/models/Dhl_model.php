<?php
declare (strict_types=1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Dhl_model extends CI_Model
{
    public $id;
    public $labelId;
    public $dhlAmount;
    public $tiqsCommission;
    public $currency;
    public $type;
    public $mgnprodcd;
    public $fromaddress;
    public $fromaddressa;
    public $fromaddresscity;
    public $fromaddresszip;
    public $fromaddresscountry;
    public $toaddress;
    public $toaddressa;
    public $toaddresscity;
    public $toaddresszip;
    public $toaddresscountry;
    private $table = 'tbl_dhl';

    public function setId(int $id): Dhl_model
    {
        $this->id = $id;
        return $this;
    }

    public function insert(array $data): bool
    {
        $data['mgnprodcd'] = $data['type'] === 'D' ? 'P' : $data['type'];
        $this->db->insert($this->table, $data);
        $this->id = $this->db->insert_id();
        return $this->id ? true:false;
    }

    public function update(array $data): bool
    {
        $this->db->where("id", $this->id);
        $this->db->update($this->table, $data);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows ? true : false;
    }

    public function delete(): bool
    {
        $this->db->where('id', $this->id);
        $this->db->delete($this->table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows ? true : false;
    }

    public function select(array $what, array $filter): ?array
    {
        $this->db->select(implode(',', $what));
        $this->db->from($this->table);
        $this->db->where($filter);
        $query = $this->db->get();
        return $query->result();
    }

    public function fetch(): array
    {
        $where = [
            $this->table.'.id=' => $this->id
        ];
        return 
        $this->db
            ->select(
                $this->table . '.labelId AS labelId, ' .
                $this->table . '.dhlAmount AS dhlAmount, ' .
                $this->table . '.tiqsCommission AS tiqsCommission, ' .
                $this->table . '.currency AS currency, ' .
                $this->table . '.type AS type, ' .
                $this->table . '.mgnprodcd AS mgnprodcd, ' .
                $this->table . '.fromaddress AS fromaddress, ' .
                $this->table . '.fromaddressa AS fromaddressa, ' .
                $this->table . '.fromaddresscity AS fromaddresscity, ' .
                $this->table . '.fromaddresszip AS fromaddresszip, ' .
                $this->table . '.fromaddresscountry AS fromaddresscountry, ' .
                $this->table . '.toaddress AS toaddress, ' .
                $this->table . '.toaddressa AS toaddressa, ' .
                $this->table . '.toaddresscity AS toaddresscity, ' .
                $this->table . '.toaddresszip AS toaddresszip, ' .
                $this->table . '.toaddresscountry AS toaddresscountry, ' .
                'label.descript AS labelDescription, 
                label.code AS labelCode,
                label.dclw AS labelDclw, 
                label.dcll AS labelDcll,
                label.dclh AS labelDclh, 
                label.dclwgt AS labelDclwgt, 

                owner.id AS ownerId,
                owner.username AS ownerUsername,
                owner.email AS ownerEmail,
                owner.roleid AS ownerRoleId,
                owner.mobile AS ownerMobile,
                owner.IsDropOffPoint AS ownerDropOffPoint,
                owner.address AS ownerAddress,
                owner.addressa AS ownerAddressa,
                owner.city AS ownerCity,
                owner.zipcode AS ownerZipcode,
                owner.country AS ownerCountry,
                owner.gmtOffSet AS ownerGmtOffSet,

                claimer.id AS claimerId,
                claimer.username AS claimerUsername,
                claimer.email AS claimerEmail,
                claimer.roleid AS claimerRoleId,
                claimer.mobile AS claimerMobile,
                claimer.IsDropOffPoint AS claimerDropOffPoint,
                claimer.address AS claimerAddress,
                claimer.addressa AS claimerAddressa,
                claimer.city AS claimerCity,
                claimer.zipcode AS claimerZipcode,
                claimer.country AS claimerCountry,
                claimer.gmtOffSet AS claimerGmtOffSet,

                finder.id AS finderId,
                finder.username AS finderUsername,
                finder.email AS finderEmail,
                finder.roleid AS finderRoleId,
                finder.mobile AS finderMobile,
                finder.IsDropOffPoint AS finderDropOffPoint,
                finder.address AS finderAddress,
                finder.addressa AS finderAddressa,
                finder.city AS finderCity,
                finder.zipcode AS finderZipcode,
                finder.country AS finderCountry,
                finder.gmtOffSet AS finderGmtOffSet,'                
            )
            ->join('tbl_label AS label', 'label.id = ' . $this->table . '.labelId', 'LEFT')
            ->join('tbl_user AS owner', 'label.userid = owner.id', 'LEFT')
            ->join('tbl_user AS claimer', 'label.userclaimid = claimer.id', 'LEFT')
            ->join('tbl_user AS finder', 'label.userfoundid = finder.id', 'LEFT')            
            ->where($where)
            ->get($this->table)            
            ->result_array();
    }
}

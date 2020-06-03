<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class User_paymenthistory_model extends CI_Model
{
    //TIQS TO DO -> refactor object, add properties and methods
    public $id;
    
    public function setId(int $id): User_paymenthistory_model
    {
        $this->id = $id;
        return $this;
    }

    public function save(array $data): ?int
    {
        $id = $this->select(['id'], ['transactionid=' => $data['transactionid']]);
        if ($id) {
            $this->id = $id[0]->id;
            $data['transactionid'] = $data['transactionid'];
            return $this->update($data) ? $this->id : null;
        }
        return $this->insert($data) ? $this->id : null;
    }


    public function insert($data): bool
    {   
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_payments_history', $data);
        $this->id = $this->db->insert_id();        
        return $this->id ? true : false;
    }
    
    public function getHistoryPaymentById($historyPaymentRecordId)
    {
        $this->db->from('tbl_payments_history');
        $this->db->where("id", $historyPaymentRecordId);
        $this->db->where("paystatus", 2);
        $this->db->where("orderstatusid", 100);
        $this->db->where("identityverified", 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function select(array $what, array $filter): ?array
    {
        $this->db->select(implode(',', $what));
        $this->db->from('tbl_payments_history');
        $this->db->where($filter);
        $query = $this->db->get();
        return $query->result();
    }

    public function update(array $update): bool
    {
        $data['update_at'] = date('Y-m-d H:i:s');
        $this->db->where("id", $this->id);
        $this->db->update('tbl_payments_history', $update);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows ? true : false;
    }

    public function fetch(array $filter = []): ?array
    {
        $where = [
            'paymentHistory.id=' => $this->id
        ];
        if ($filter) {
            foreach($filter as $key => $value) {
                $where[$key] = $value;
            }
        }
        return
        $this->db
            ->select(
                'paymentHistory.id AS historyId,
                paymentHistory.paystatus AS historyPaystatus,
                paymentHistory.orderstatusid AS history,
                paymentHistory.paymentSessionId AS historyPaymentSessionId,
                paymentHistory.identityverified AS historyIdentityverified,

                dhl.id AS dhlId,
                dhl.labelId AS labelId,
                dhl.dhlAmount AS dhlAmount,
                dhl.tiqsCommission AS dhlTiqsCommission,
                dhl.currency AS dhlCurrency,
                dhl.type AS type,
                dhl.mgnprodcd AS dhlMgnprodcd,
                dhl.fromaddress AS dhlFromaddress,
                dhl.fromaddressa AS dhlFromaddressa,
                dhl.fromaddresscity AS dhlFromaddresscity,
                dhl.fromaddresszip AS dhlFromaddresszip,
                dhl.fromaddresscountry AS dhlFromaddresscountry,
                dhl.toaddress AS dhlToaddress,
                dhl.toaddressa AS dhlToaddressa,
                dhl.toaddresscity AS dhlToaddresscity,
                dhl.toaddresszip AS dhlToaddresszip,
                dhl.toaddresscountry AS dhlToaddresscountry,
                dhl.dhlmessage AS dhlMessage,
                dhl.dhlcode AS dhlCode,
                dhl.dhlordernr AS dhlOrdernr,

                label.id AS laeblId,
                label.descript AS labelDescription, 
                label.code AS labelCode,
                label.dclw AS labelDclw, 
                label.dcll AS labelDcll,
                label.dclh AS labelDclh, 
                label.dclwgt AS labelDclwgt,

                category.description AS categoryDescription,

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
                finder.gmtOffSet AS finderGmtOffSet'                
            )
            ->join('tbl_dhl AS dhl', 'dhl.id = paymentHistory.dhlId', 'RIGHT')
            ->join('tbl_label AS label', 'label.id = dhl.labelId', 'RIGHT')
            ->join('tbl_user AS owner', 'label.userid = owner.id', 'RIGHT')
            ->join('tbl_user AS claimer', 'label.userclaimid = claimer.id', 'RIGHT')
            ->join('tbl_user AS finder', 'label.userfoundid = finder.id', 'RIGHT')
            ->join('tbl_category AS category', 'label.categoryid = category.id', 'RIGHT')
            ->where($where)
            ->get('tbl_payments_history AS paymentHistory')
            ->result_array();
    }
}

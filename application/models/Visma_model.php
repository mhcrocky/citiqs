<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visma_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function update_access_data($data)
    {

        $this->db->where("user_ID", $data['user_ID']);
        $this->db->update('tbl_export_setting', ['visma_access_token' => $data['visma_access_token'], 'visma_refresh_token' => $data['visma_refresh_token'], 'visma_option' => 1]);
    }
    public function insert_access_data($data)
    {
        $this->db->insert('tbl_export_setting', $data);
    }


    public function get_visma_vat($user_ID, $vat)
    {
        $this->db->select('*')
            ->from('vat_rates')
            ->where("user_ID", (int) $user_ID)
            ->where("rate_perc", $vat);
        $q = $this->db->get();
        if ($q->num_rows()) {
            return $q->row();
        } else {
            return false;
        }
    }

    public function get_visma_service($id, $service_id)
    {
        $this->db->select('*')
            ->from('tbl_export_services')
            ->where('user_ID', $id)
            ->where('service_id', $service_id)
            ->limit(1);

        $q = $this->db->get();


        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function get_visma_creditor($user_ID, $category_ID)
    {
        $this->db->select('*')
            ->from('tbl_export_creditor')
            ->where("user_ID", (int) $user_ID)
            ->where('external_id !=""')
            ->where('accounting ="visma"')
            ->where("product_category_ID", (int) $category_ID);
        $q = $this->db->get();
        // echo $this->db->last_query();
        if ($q->num_rows()) {
            return $q->row();
        } else {
            return false;
        }
    }

    public function get_visma_debitor($user_ID, $payment_type)
    {
        $this->db->select('*')
            ->from('tbl_export_debitor')
            ->where("user_ID", (int) $user_ID)
            ->where('external_id !=""')
            ->where('accounting ="visma"')
            ->where("payment_type", $payment_type);
        $q = $this->db->get();
        if ($q->num_rows()) {
            return $q->row();
        } else {
            return false;
        }
    }

    public function update_vat_rates($user_ID, $vat_ID_SHA1, $vat_code)
    {
        $this->db->set('rate_export', $vat_code)
            ->where('user_ID', (int) $user_ID)
            ->where('SHA1(rate_ID)', $vat_ID_SHA1)
            ->update('vat_rates');
    }


    public function get_data($user_ID)
    {
        $this->db->select("*")
            ->from('tbl_export_setting')
            ->where('user_ID', (int) $user_ID)
            ->limit(1);

        $q = $this->db->get();
        return ($q->num_rows() == 1 ? $q->row() : false);
    }

    public function update_status($user_ID, $status)
    {
        $this->db->set('visma_status', ($status ? 1 : 0))
            ->where('user_ID', (int) $user_ID)
            ->db->update('user_settings');
        return $this->db->total_queries();
    }

    public function update_order_export_status($order_id, $export_id)
    {
        $this->db->set('export_id', ($export_id))->where('id', (int) $order_id)->update('tbl_shop_orders');
        return $this->db->total_queries();
    }

    public function update_visma_settings($user_ID, $data)
    {
        $this->db->set('visma_year', trim($data['visma_year']));
        $this->db->set('visma_option', 1);

        $this->db->where('user_ID', (int) $user_ID);
        $this->db->update('tbl_export_setting');

        $result = $this->db->total_queries();
        return $result;
    }
    public function get_order_products($order_id)
    {
        $result = $this->db->query('SELECT
            tbl_shop_products_extended.vatpercentage AS productVat,
            tbl_shop_products_extended.`name` AS productName,
            tbl_shop_products_extended.price,
            tbl_shop_products_extended.id,
            tbl_shop_order_extended.quantity,
            tbl_shop_categories.category,
            tbl_shop_categories.id AS cat_id,
            tbl_shop_products_extended.price * tbl_shop_order_extended.quantity
            AS AMOUNT,
            ROUND(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100),2)
            AS EXVAT,
            ROUND(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity,2)
            -
            ROUND(tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100),2)
            AS VAT

        FROM
            tbl_shop_products_extended
        INNER JOIN
            tbl_shop_order_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
        LEFT JOIN
            tbl_shop_products ON tbl_shop_products_extended.productId = tbl_shop_products.id
        LEFT JOIN
            tbl_shop_categories ON tbl_shop_products.categoryId = tbl_shop_categories.id
        WHERE
            tbl_shop_order_extended.orderId = "' . $order_id . '"
        ');

        $result = $result->result_array();

        return $result ? $result : null;
    }

    public function get_order_vat($order_id)
    {
        $result = $this->db->query('SELECT
            tbl_shop_products_extended.vatpercentage AS productVat,
            tbl_shop_products_extended.`name` AS productName,
            tbl_shop_products_extended.price,
            tbl_shop_order_extended.quantity,
            tbl_shop_categories.category,
            tbl_shop_categories.id AS cat_id,

            tbl_shop_products_extended.price * tbl_shop_order_extended.quantity
            AS AMOUNT,
            tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100)
            AS EXVAT,
            tbl_shop_products_extended.price * tbl_shop_order_extended.quantity
            -
            tbl_shop_products_extended.price * tbl_shop_order_extended.quantity * 100 / (tbl_shop_products_extended.vatpercentage+100)
            AS VAT

        FROM
            tbl_shop_products_extended
        INNER JOIN
            tbl_shop_order_extended ON tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
        INNER JOIN
            tbl_shop_orders ON tbl_shop_order_extended.orderId = tbl_shop_orders.id
        LEFT JOIN
            tbl_shop_products ON tbl_shop_products_extended.productId = tbl_shop_products.id
        LEFT JOIN
            tbl_shop_categories ON tbl_shop_products.categoryId = tbl_shop_categories.id
        INNER JOIN
            tbl_shop_vendors ON  tbl_shop_vendors.vendorId = tbl_shop_categories.userId

        WHERE
            tbl_shop_order_extended.orderId = "' . $order_id . '"
        ');

        $result = $result->result_array();

        return $result ? $result : null;
    }
    public function fetchOrdersForPrintcopy(string $orderIdcopy): ?array
    {
        $this->load->config('custom');
        $concatSeparator = $this->config->item('concatSeparator');
        $concatGroupSeparator = $this->config->item('contactGroupSeparator');

        $query =
            'SELECT
            tbl_shop_orders.id AS orderId,
            tbl_shop_orders.spotId,
            tbl_shop_orders.paymentType,
            tbl_shop_orders.amount,
            tbl_shop_spot_types.type AS service_type,
            tbl_shop_orders.created AS orderCreated,
            tbl_shop_orders.expired AS orderExpired,
            tbl_shop_orders.serviceFee AS serviceFee,
            tbl_shop_orders.printStatus AS printStatus,
            tbl_shop_spots.spotName,
            (tbl_shop_orders.serviceFee)*(tbl_shop_vendors.serviceFeeTax/100) AS VATSERVICE,
            GROUP_CONCAT(tbl_shop_order_extended.id) AS orderExtendedIds,
            tbl_user.username AS buyerUserName,
            tbl_user.id AS user_ID,
            tbl_user.email AS buyerEmail,
            tbl_user.mobile AS buyerMobile,
            vendorOne.logo AS vendorLogo,
            vendorOne.id as vendorId,
            vendorOne.username as vendorName,
            vendorOne.address as vendorAddress,
            vendorOne.zipcode as vendorZipcode,
            vendorOne.city as vendorCity,
            vendorOne.vat_number as vendorVAT,
            vendorOne.country as vendorCountry,
            tbl_shop_vendors.serviceFeeTax as serviceFeeTax,
            tbl_shop_vendors.id as serviceId
        FROM
            tbl_shop_orders
        INNER JOIN
            tbl_shop_spots ON tbl_shop_spots.id = tbl_shop_orders.spotId
        INNER JOIN
            tbl_user ON tbl_user.id = tbl_shop_orders.buyerId
        INNER JOIN
            tbl_shop_order_extended ON tbl_shop_order_extended.orderId = tbl_shop_orders.id
        INNER JOIN
            tbl_shop_products_extended ON tbl_shop_products_extended.id = tbl_shop_order_extended.productsExtendedId
        INNER JOIN
            tbl_shop_products ON tbl_shop_products.Id = tbl_shop_products_extended.productId
        INNER JOIN
            tbl_shop_categories ON tbl_shop_categories.id = tbl_shop_products.categoryId
        INNER JOIN
            tbl_shop_spot_types ON tbl_shop_orders.serviceTypeId = tbl_shop_spot_types.id
        INNER JOIN
        (
            SELECT
                tbl_user.*
            FROM
                tbl_user
            WHERE tbl_user.roleid = ' . $this->config->item('owner') . '
        ) vendorOne ON vendorOne.id = tbl_shop_categories.userId
        INNER JOIN
            tbl_shop_vendors ON tbl_shop_vendors.vendorId = vendorOne.id
        WHERE
            tbl_shop_orders.paid = "1"
            AND tbl_shop_orders.id = "' . $orderIdcopy . '"
        GROUP BY orderId';
        // echo $query;
        // exit;
        $result = $this->db->query($query);
        $resultqueryforlog = $this->db->last_query();
        $logFile = FCPATH . 'application/tiqs_logs/messages.txt';
        $result = $result->result();
        return $result ? $result : null;
    }
    public function get_products($user_ID)
    {
        $q = $this->db->query("SELECT px.id,px.name,px.price FROM tbl_shop_products_extended as px INNER JOIN tbl_shop_products as p ON p.id=px.productId INNER JOIN tbl_shop_categories as cat on p.categoryId=cat.id WHERE cat.userId = '$user_ID'");
        return ($q->num_rows()  ? $q->result() : false);
    }
}

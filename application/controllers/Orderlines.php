<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';
// use DB;
class Orderlines extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('country_helper');
        $this->load->helper('form');
        $this->load->helper('google_helper');
        $this->load->library('form_validation');



        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->library('pagination');

        $this->load->config('custom');

        $this->isLoggedIn();


    }

    /**
     * This function used to load the first screen of the user
     */
    public function index() {
        // echo 'here';
        // exit;
        $this->global['pageTitle'] = 'tiqs : Invoices';
        $result = $this->db->query('
            SELECT
                tbl_shop_orders.id AS orderId,
                tbl_shop_orders.export_ID AS export_ID,
                tbl_shop_orders.amount AS orderAmount,
                tbl_shop_orders.paid AS orderPaidStatus,
                tbl_shop_orders.created AS createdAt,
                tbl_shop_categories.category AS category,
                buyer.id AS buyerId,
                buyer.email AS buyerEmail,
                buyer.username AS buyerUserName,
                vendor.username AS vendorUserName,
                tbl_shop_order_extended.quantity AS productQuantity,
                tbl_shop_products_extended.`name` AS productName,
                tbl_shop_products_extended.price AS productPrice,
                tbl_shop_products_extended.vatpercentage AS productVat,
                tbl_shop_spots.spotName AS spotName,
                tbl_shop_products_extended.price * tbl_shop_order_extended.quantity AS productlinetotal,
                ((tbl_shop_products_extended.price * tbl_shop_order_extended.quantity) * 100)/(tbl_shop_products_extended.vatpercentage+100) AS EXVAT,
                tbl_shop_orders.serviceFee AS servicefee
            FROM
                tbl_shop_orders
                INNER JOIN
                tbl_shop_order_extended
                ON
                    tbl_shop_orders.id = tbl_shop_order_extended.orderId
                INNER JOIN
                tbl_shop_products_extended
                ON
                    tbl_shop_order_extended.productsExtendedId = tbl_shop_products_extended.id
                INNER JOIN
                tbl_shop_products
                ON
                    tbl_shop_products_extended.productId = tbl_shop_products.id
                INNER JOIN
                tbl_shop_categories
                ON
                    tbl_shop_products.categoryId = tbl_shop_categories.id
                INNER JOIN
                (
                    SELECT
                        *
                    FROM
                        tbl_user
                    WHERE
                        roleid = 2
                ) AS vendor
                ON
                    vendor.id = tbl_shop_categories.userId
                INNER JOIN
                (
                    SELECT
                        *
                    FROM
                        tbl_user
                    WHERE
                        roleid = 6 OR
                        roleid = 2
                ) AS buyer
                ON
                    buyer.id = tbl_shop_orders.buyerId
                INNER JOIN
                tbl_shop_spots
                ON
                    tbl_shop_orders.spotId = tbl_shop_spots.id
            WHERE
                vendor.id = '.$this->session->userdata('userId').' AND
                tbl_shop_orders.paid = \'1\'
            GROUP BY
                orderId
            ORDER BY
                tbl_shop_categories.category ASC

    ');
    if($result->num_rows()){
        $data['invoices'] = $result->result();
    }else{
        $data['invoices'] = [];
    }
    $this->loadViews("order_lines", $this->global, $data, NULL,'headerWarehouse');
    }
}

?>

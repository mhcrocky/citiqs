<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_tbl_shop_vendor_types extends CI_Migration {

	public function up()
	{
        $query = 
            "
            CREATE TABLE IF NOT EXISTS tbl_shop_vendor_types (
                id              INT             UNSIGNED NOT NULL AUTO_INCREMENT,
                vendorId        INT             UNSIGNED NOT NULL,
                typeId          INT             UNSIGNED NOT NULL DEFAULT '1',
                active          ENUM('0', '1')  NOT NULL DEFAULT '1',
                PRIMARY KEY(id),
                FOREIGN KEY(vendorId) REFERENCES tbl_user(id),
                FOREIGN KEY(typeId) REFERENCES tbl_shop_spot_types(id)
            );
            ";
        $this->db->query($query);

        // $query = 'INSERT INTO `tbl_shop_vendor_types` (vendorId) SELECT vendorId FROM tbl_shop_vendors;';
        // $this->db->query($query);

        // $query = "ALTER TABLE `tbl_shop_vendor_types` CHANGE `typeId` `typeId` INT(10) UNSIGNED NOT NULL DEFAULT '2';";
        // $this->db->query($query);

        // $query = "ALTER TABLE `tbl_shop_vendor_types` CHANGE `active` `active` ENUM('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0';";
        // $this->db->query($query);

        // $query = "INSERT INTO `tbl_shop_vendor_types` (vendorId) SELECT vendorId FROM tbl_shop_vendors;";
        // $this->db->query($query);

        // $query = "ALTER TABLE `tbl_shop_vendor_types` CHANGE `typeId` `typeId` INT(10) UNSIGNED NOT NULL DEFAULT '3';";
        // $this->db->query($query);

        // $query = "INSERT INTO `tbl_shop_vendor_types` (vendorId) SELECT vendorId FROM tbl_shop_vendors;";
        // $this->db->query($query);

        // $query = "ALTER TABLE `tbl_shop_vendor_types` CHANGE `typeId` `typeId` INT(10) UNSIGNED NOT NULL DEFAULT '1';";
        // $this->db->query($query);
	}

	public function down()
	{
        $query = 'DROP TABLE tbl_shop_vendor_types;';
        $this->db->query($query);
		
	}
}

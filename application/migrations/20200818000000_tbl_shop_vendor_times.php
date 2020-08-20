<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_tbl_shop_vendor_times extends CI_Migration {

	public function up()
	{
        $query = 
            "
            CREATE TABLE IF NOT EXISTS tbl_shop_vendor_times (
                id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
                vendorId    INT UNSIGNED    NOT NULL,
                day         ENUM('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun') NOT NULL,
                timeFrom    TIME            NOT NULL DEFAULT '00:00:00',
                timeTo      TIME            NOT NULL DEFAULT '23:59:59',
                PRIMARY KEY(id),
                FOREIGN KEY(vendorId) REFERENCES tbl_user(id)
            );
            ";
        $this->db->query($query);
	}

	public function down()
	{
        $query = 'DROP TABLE tbl_shop_vendor_times;';
        $this->db->query($query);
		
	}
}





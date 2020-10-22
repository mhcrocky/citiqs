<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_tbl_vendor_FODNumber extends CI_Migration {

	public function up()
	{
			$query = 
				"
				CREATE TABLE IF NOT EXISTS tbl_vendor_fodnumber ( 
					id				INT			UNSIGNED NOT NULL AUTO_INCREMENT ,
					vendorId		INT			UNSIGNED NOT NULL ,
					lastNumber		BIGINT		UNSIGNED NOT NULL DEFAULT '0' ,
					PRIMARY KEY (id),
					FOREIGN KEY(vendorId) REFERENCES tbl_user(id)
				) ENGINE = InnoDB;
            ";
        $this->db->query($query);
	}

	public function down()
	{
        $query = 'DROP TABLE tbl_vendor_fodnumber;';
        $this->db->query($query);
		
	}
}

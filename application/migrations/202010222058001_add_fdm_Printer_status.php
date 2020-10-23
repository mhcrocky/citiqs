<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_fdm_Printer_status extends CI_Migration {

	public function up()
	{
		$query = 
			"
			CREATE TABLE IF NOT EXISTS tbl_FDM_printer_status ( 
				id				INT			UNSIGNED NOT NULL AUTO_INCREMENT ,
				printer_id		INT			UNSIGNED NOT NULL ,
				FDM_active		INT			UNSIGNED NOT NULL DEFAULT '0' ,
				updated_at TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id),
				FOREIGN KEY(printer_id) REFERENCES tbl_shop_printers(id)
			) ENGINE = InnoDB;
		";
		$this->db->query($query);
	}

	public function down()
	{
		$query = 'DROP TABLE tbl_FDM_printer_status;';
		$this->db->query($query);
		
	}
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_tbl_shop_venodrs extends CI_Migration {

	public function up()
	{
        $query = 'ALTER TABLE tbl_shop_vendors ADD COLUMN cash ENUM("0", "1") DEFAULT "0" AFTER creditCard;';

        $this->db->query($query);
	}

	public function down()
	{
        $query = 'ALTER TABLE tbl_shop_vendors DROP COLUMN cash;';
        $this->db->query($query);
	}
}

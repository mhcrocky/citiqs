<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_tbl_shop_orders extends CI_Migration {
	public function up()
	{
        $query = 'ALTER TABLE `tbl_shop_orders` MODIFY COLUMN `paid` enum( "0", "1", "2") DEFAULT "0";';

        $this->db->query($query);
	}

	public function down()
	{
        $query = 'ALTER TABLE `tbl_shop_orders` MODIFY COLUMN `paid` enum( "0", "1") DEFAULT "0";';
        $this->db->query($query);
	}
}


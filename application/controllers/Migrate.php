<?php
require APPPATH . '/libraries/BaseControllerWeb.php';

class Migrate extends BaseControllerWeb
{

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        } else {

            if ($this->input->get('empty_floorplan_data') == 'true') {
                $this->db->empty_table('tbl_floorplan_areas');
                $this->db->empty_table('tbl_floorplan_details');
                $this->load->helper('file');
                delete_files($this->config->item('floorPlansFolder'));

            }
            echo 'Migration complete';
        }
    }

}

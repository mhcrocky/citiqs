<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model
{
    function log($type, $file, $line, $description, $extra1 = '', $extra2 = '')
    {
        $logInfo = array(
            'type' => $type,
            'datetime' => date('Y-m-d H:i:s' ),
            'file' => $file,
            'line' => $line,
            'description' => $description,
            'extra1' => $extra1,
            'extra2' => $extra2,
        );

        try {
            // $this->db->trans_start();
            if ($this->db->insert('tbl_log', $logInfo))
                $insert_id = $this->db->insert_id();
            else
                $insert_id = -1;
            //$this->db->trans_complete();
            return $insert_id;
        }

        catch (Exception $ex)
        {
            return -1;
        }
    }
}

?>

<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Language_model extends CI_Model
{
    function storetranslation($key, $lang, $text)
    {
        $translation = array(
            'key' => $key,
            'lang' => $lang,
            'text' => $text,
        );
        try {
            // Hier checken of het record misschien al bestaat
            // dan overschrijven?
            // bij de volgende keer laden staat deze er dan al in.
            // $this->db->trans_start();
            if ($this->db->insert('tbl_language', $translation))
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
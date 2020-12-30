<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Events_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tbl_event by id
     */
    function get_tbl_event($id)
    {
        return $this->db->get_where('tbl_events',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all tbl_events
     */
    function get_all_tbl_events()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('tbl_events')->result_array();
    }
        
    /*
     * function to add new tbl_event
     */
    function add_tbl_event($params)
    {
        $this->db->insert('tbl_events',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tbl_event
     */
    function update_tbl_event($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('tbl_events',$params);
    }
    
    /*
     * function to delete tbl_event
     */
    function delete_tbl_event($id)
    {
        return $this->db->delete('tbl_events',array('id'=>$id));
    }
}
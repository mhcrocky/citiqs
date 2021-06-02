<?php

function delete_unsaved_floorplans (): void
{
    $ci=& get_instance();
    $ci->load->database();
    $ci->load->model('floorplan_model');
    $ci->load->library('session');
    if (empty($ci->session->userdata('unsaved_floorplan_id'))) return;
    
    $unsaved_floorplan_id = $ci->session->userdata('unsaved_floorplan_id');
    $unsaved_floorplan = $ci->floorplan_model->read(
        ['*'],
        ['id=' => $unsaved_floorplan_id]
    );
    if ($unsaved_floorplan) {
        unlink($ci->config->item('floorPlansFolder') . DIRECTORY_SEPARATOR . $unsaved_floorplan[0]['file_name']);
        $ci->floorplan_model->id = $unsaved_floorplan[0]['id'];
        $ci->floorplan_model->delete();
    }

    $ci->session->unset_userdata('unsaved_floorplan_id');

    return;
}

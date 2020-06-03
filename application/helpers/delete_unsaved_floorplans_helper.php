<?php

function delete_unsaved_floorplans () {
    $ci=& get_instance();
    $ci->load->database();
    $ci->load->model('floorplandetails_model');
    $ci->load->library('session');
    if ($ci->session->userdata('unsaved_floorplan_id')) {
        $unsaved_floorplan_id = $ci->session->userdata('unsaved_floorplan_id');
        $unsaved_floorplan = $ci->floorplandetails_model->read(
            ['*'],
            ['id=' => $unsaved_floorplan_id]
        );
        if ($unsaved_floorplan) {
            unlink($ci->config->item('floorPlansFolder') . DIRECTORY_SEPARATOR . $unsaved_floorplan[0]['file_name']);
            $ci->floorplandetails_model->id = $unsaved_floorplan[0]['id'];
            $ci->floorplandetails_model->delete();
        }

        $ci->session->unset_userdata('unsaved_floorplan_id');
    }
}

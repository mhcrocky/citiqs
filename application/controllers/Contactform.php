<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class contactform extends BaseControllerWeb
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('curl_helper');
        $this->load->library('form_validation');
        $this->load->library('language', array('controller' => $this->router->class));
        $this->load->config('custom');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'TIQS : CONTACT';
        $data = [
            'status' => $this->config->item('apiLeadStatus'),
            'source' => $this->config->item('apiLeadSource'),
        ];
        $this->loadViews("contactform", $this->global, $data, NULL);
    }

    public function actionContactForm()
    {   
        $this->form_validation->set_rules('source','Source','trim|required|numeric');
        $this->form_validation->set_rules('status','Status','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('description','Description','trim|required|max_length[128]');

        if ($this->form_validation->run()) {
            $url = PERFEX_API . '/leads/data';
            $headers = ['authtoken:' . PERFEX_API_KEY];
            $post = $this->input->post(null, true);
            $response = Curl_helper::sendCurlPostRequest($url, $post, $headers);
            if ($response->status && $response->message === 'Lead add successful.') {
                $this->session->set_flashdata('success', 'Thank you for your message. We shall response on it as soon as possible.');
            } else {
                $this->session->set_flashdata('error', 'Message didn\'t sent. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error', 'Message didn\'t sent. Please check your data.');
        }
        redirect('/contactform');
    }
}
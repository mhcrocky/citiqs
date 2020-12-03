<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Emaildesigner extends BaseControllerWeb
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('email_templates_model');
//        $this->load->helper('my_file_helper');
        $this->isLoggedIn();
    }

    public function index()
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['page'] = 'Email Templates List';

        $this->global = [
            'user' => $this->user_model,
            'pageTitle' => 'Email Templates List'
        ];

        $data = [
            'user' => $this->user_model,
            'emails' => $this->email_templates_model->get_emails_by_user($this->user_model->id)
        ];

        $this->loadViews("email_designer_list", $this->global, $data, "footerbusiness", "headerbusiness");
    }

    public function edit($email_id = null)
    {
        $this->user_model->setUniqueValue($this->userId)->setWhereCondtition()->setUser();
        $this->global['page'] = 'Email Designer';

        $this->global = [
            'user' => $this->user_model,
            'images_path' => base_url() . 'assets/user_images/' . $this->user_model->id,
            'template_id' => $email_id,
            'pageTitle' => 'Email editor'
        ];

        $data = [];

        if ($email_id) {
            $email_template = $this->email_templates_model->get_emails_by_id($email_id);
            $data['email_template'] = $email_template;
            $data['template_html'] = read_file(FCPATH . 'assets/email_templates/' . $this->user_model->id . '/' . $email_template->template_file);
        }

        $this->loadViews("email_designer", $this->global, $data, 'footerbusiness', 'headerbusiness');
    }
}


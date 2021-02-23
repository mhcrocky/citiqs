<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseControllerWeb.php';

    class Templates extends BaseControllerWeb
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->model('shoptemplates_model');

            $this->load->config('custom');

            $this->load->library('language', array('controller' => $this->router->class));
            $this->load->library('session');

            $this->isLoggedIn();
        }

        public function index(): void
        {

            redirect('add_template');

        }

        public function addTemplate(): void
        {
            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
            ];

            $this->global['pageTitle'] = 'TIQS : ADD TEMPLATE';
            $this->loadViews('templates/addTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function updateTemplate($id): void
        {
            $this->shoptemplates_model->setObjectId(intval($id))->setObject();

            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
                'templateId' => $id,
				'templateName' => $this->shoptemplates_model->template_name,
				'templateContent' => file_get_contents($this->shoptemplates_model->getTemplateFile())
            ];

            $this->global['pageTitle'] = 'TIQS : UPDATE TEMPLATE';
            $this->loadViews('templates/updateTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function listTemplates(): void
        {
            $userId = intval($_SESSION['userId']);

            $data = [
                'templates' => $this->shoptemplates_model->setProperty('user_id', $userId)->fetchTemplates(),
                'updateTemplate' => base_url() . 'update_template' . DIRECTORY_SEPARATOR,
            ];

            $this->global['pageTitle'] = 'TIQS : LIST TEMPLATE';
            $this->loadViews('templates/listTemplates', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

    }

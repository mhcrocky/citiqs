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
            $this->load->model('shoplandingpages_model');

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
                'productGroups' => $this->config->item('productGroups'),
                'landingPages' => $this->config->item('landingPages'),
                'landingTypes' => $this->config->item('landingTypes'),
                'urlType' => $this->config->item('urlLanding'),
                'templateType' => $this->config->item('templateLanding'),
            ];

            $this->global['pageTitle'] = 'TIQS : ADD TEMPLATE';
            $this->loadViews('templates/addTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function updateTemplate($id): void
        {
            $this->shoptemplates_model->setObjectId(intval($id))->setObject();

            // to check id

            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
                'templateId' => $id,
				'templateName' => $this->shoptemplates_model->template_name,
                'templateSubject' => $this->shoptemplates_model->template_subject,
                'templateType' => $this->shoptemplates_model->template_type,
				'templateContent' => file_get_contents($this->shoptemplates_model->getTemplateFile())
            ];

            $this->global['pageTitle'] = 'TIQS : UPDATE TEMPLATE';
            $this->loadViews('templates/updateTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function listTemplates(): void
        {
            $userId = intval($_SESSION['userId']);
            $baseUrl = base_url();

            $data = [
                'templates' => $this->shoptemplates_model->setProperty('user_id', $userId)->fetchTemplates(),
                'updateTemplate' => $baseUrl . 'update_template' . DIRECTORY_SEPARATOR,
                'landingPages' => $this->shoplandingpages_model->setProperty('vendorId', $userId)->getVendorLandingPages(),
                'baseUrl' => $baseUrl,
            ];

            $this->global['pageTitle'] = 'TIQS : LIST TEMPLATE';
            $this->loadViews('templates/listTemplates', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function updateLandingPageStatus($id, $newStatus): void
        {
            $get = $this->security->xss_clean($_GET);
            $vendorId = intval($_SESSION['userId']);
            $this
                ->shoplandingpages_model
                ->setObjectId(intval($id))
                ->setProperty('vendorId', $vendorId)
                ->setProperty('active', $newStatus)
                ->setProperty('productGroup', base64_decode($get['group']));

            if (!$this->shoplandingpages_model->isVenodrPage()) {
                $this->session->set_flashdata('error', 'Not allowed');
            } else {
                if ($this->shoplandingpages_model->updateActiveStatus()) {
                    $this->session->set_flashdata('success', 'Status updated');
                } else {
                    $this->session->set_flashdata('error', 'Update failed');
                }
            }

            redirect('list_template');
            return;
        }

    }

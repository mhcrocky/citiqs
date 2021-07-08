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

            $this->load->helper('utility_helper');

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
            $this->load->model('email_templates_model');
            $data = [
                'emailTemplates' => $this->config->item('emailTemplates'),
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
                'productGroups' => $this->config->item('productGroups'),
                'landingPages' => $this->config->item('landingPages'),
                'landingTypes' => $this->config->item('landingTypes'),
                'urlType' => $this->config->item('urlLanding'),
                'templateType' => $this->config->item('templateLanding'),
                'emailTemplatesEdit' => true,
                'landingPagesEdit' => true,
                'defaultTemplates' => $this->email_templates_model->getDefaultTemplate(),
                'testing' => Utility_helper::testingVendors(intval($_SESSION['userId']))
            ];

            $this->global['pageTitle'] = 'TIQS : ADD TEMPLATE';
            $this->loadViews('templates/addTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        public function updateTemplate($id, $isLandingPage = ''): void
        {
            $this->load->model('email_templates_model');
            $data = [
                'vendorId' => intval($_SESSION['userId']),
                'tiqsId' => $this->config->item('tiqsId'),
                'defaultTemplates' => $this->email_templates_model->getDefaultTemplate(),
                'testing' => Utility_helper::testingVendors(intval($_SESSION['userId']))
            ];
   
            if (empty($isLandingPage)) {
                $this->setEmailTemplateUpdate($data, intval($id));
            } else {
                $this->setLandingPageUpdate($data, intval($id));
            }

            $this->global['pageTitle'] = 'TIQS : UPDATE TEMPLATE';
            $this->loadViews('templates/updateTemplate', $this->global, $data, 'footerbusiness', 'headerbusiness');
            return;
        }

        private function setEmailTemplateUpdate(array &$data, int $id): void
        {
            $this->shoptemplates_model->setObjectId($id)->setObject();
            // to check id
            $data['emailTemplates'] = $this->config->item('emailTemplates');
            $data['templateId'] = $id;
            $data['templateName'] = $this->shoptemplates_model->template_name;
            $data['templateSubject'] = $this->shoptemplates_model->template_subject;
            $data['templateType'] = $this->shoptemplates_model->template_type;

            $unlayerObjectFile = $this->shoptemplates_model->getUnlayerObjectFile();

            if (file_exists($unlayerObjectFile)) {
                $unlayerDesign = file_get_contents($unlayerObjectFile);
                $unlayerDesign = json_decode($unlayerDesign, true);
                // echo '<pre>';
                // print_r(json_decode($unlayerDesign, true));
                // die();

                $unlayerDesign = json_encode( $unlayerDesign, JSON_HEX_QUOT|JSON_HEX_APOS );
                $unlayerDesign = str_replace("\u0022", "\\\"", $unlayerDesign );
                $unlayerDesign = str_replace("\u0027", "\\'",  $unlayerDesign );
                
                $data['unlayerDesign'] = $unlayerDesign;
            } else {
                $data['templateContent'] = file_get_contents($this->shoptemplates_model->getTemplateFile());
            }

            $data['emailTemplatesEdit'] = true;
            $data['landingPagesEdit'] = false;

            return;
        }

        public function setLandingPageUpdate(array &$data, int $id): void
        {
            $this
                ->shoplandingpages_model
                ->setObjectId($id)
                ->setProperty('vendorId', $data['vendorId']);
            if (!$this->shoplandingpages_model->isVenodrPage()) {
                redirect('list_template');
            }
            $this->shoplandingpages_model->setObject();

            $data['emailTemplatesEdit'] = false;
            $data['landingPagesEdit'] = true;
            $data['productGroups'] = $this->config->item('productGroups');
            $data['landingPages'] = $this->config->item('landingPages');
            $data['landingTypes'] = $this->config->item('landingTypes');
            $data['urlType'] = $this->config->item('urlLanding');
            $data['templateType'] = $this->config->item('templateLanding');
            $data['landingPage'] = $this->shoplandingpages_model;

            $this->getLandingPageHtml($data);

            return;
        }

        private function getLandingPageHtml(array &$data): void
        {
            $landingPage = $data['landingPage'];
            if ($landingPage->landingType === $this->config->item('templateLanding')) {
                $htmlTemplate = $this->config->item('landingPageFolder') . $landingPage->value . '.' . $this->config->item('landingTemplateExt');
                $data['templateContent'] = file_get_contents($htmlTemplate);
            }
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
                ->setProperty('landingPage', $this->shoplandingpages_model->getProperty('landingPage'))
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

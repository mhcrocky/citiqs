<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerWeb.php';

class Translate extends BaseControllerWeb {

    /**
     * This is default constructor of the class
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('translation_model');
        $this->load->library('language', array('controller' => $this->router->class));
		$this->load->library('session');
        #$this->isLoggedIn();
    }

    public function index() {
        $data["results"] = $this->translation_model->getLanguages();
        $this->global['pageTitle'] = 'tiqs : Translation';
        //if ($this->input->post()) {
            //$language = $this->security->xss_clean($this->input->post('language'));
			//$this->session->set_userdata('translanguage', $language);
            //$data["translations"] = $this->translation_model->getTranslationsByLanguage($language);
            //$this->loadViews("translation-table", $this->global, $data, NULL);
        //} else {
        $this->loadViews("translation-table", $this->global, $data, NULL);
        //}
    }

    public function get_languages() {

        $language = ($this->input->post('language')) ? $this->security->xss_clean($this->input->post('language')) : '';
		$this->session->set_userdata('translanguage', $language);
        $translations = $this->translation_model->getTranslationsByLanguage($language);
        echo json_encode($translations);

    }
 
    public function editTranslation($recordId) {
        if ($this->input->post()) {
            $correctedTranslation = $this->security->xss_clean($this->input->post('correctedTranslation'));
//			$this->phpAlert($correctedTranslation);
            $row = array(
                "text" => $correctedTranslation
            );
            $result = $this->translation_model->updateTranslation($recordId, $row);
            if ($result >= 0) {
                 echo "Translation successfully updated! You can close the window.";
            } else {
                echo "An error occured! Try again.";
            }
        } else {
            echo "An error occured! Try again.";
        }
    }

	public function deleteTranslation($recordId) {
		$result = $this->translation_model->deleteTranslation($recordId);
		if ($result > 0) {
			echo "Translation successfully deleted, refresh screen";
			$language = $this->session->userdata('translanguage');
			$data["translations"] = $this->translation_model->getTranslationsByLanguage($language);
			$this->loadViews("translation-table", $this->global, $data, NULL);
			header("Refresh:0");
		} else {
			echo "An error occured! Try again.";
		}
	}


    public function getTranslation($id) {
        $translation = $this->translation_model->getTranslationsById($id);
        if (empty($translation)) {
            $html = '<form id="editTranslation" action="" style="display: none;width:100%;max-width:400px;">
                <h4 class="mb-3">
                    Translation Edit:
                </h4>
                <p>An error occured! Try again.</p>
                <p class="mb-0 text-right">
                    <input id="saveTranslation" type="button" id="saveTranslation" class="btn btn-primary" value="Close" />
                </p>
            </form>';
        } else {
            $html = '<form id="editTranslation" action="" style="display: none;width:100%;max-width:400px;">
            <h4 class="mb-3">
                Translation Edit:
            </h4>
            <textarea style="width:310px;height:220px;" id="translationText">' . $translation[0]->text . '</textarea>
            <p></p>
            <p class="mb-0 text-right">
                <input type="hidden" id="id" value="' . $id . '"/>
                <input id="saveTranslation" type="button" id="saveTranslation" class="btn btn-primary" value="Save" />
            </p>
        </form>';
        }
        echo $html;
    }

//	function phpAlert($msg) {
//    	log_message(4,$msg);
//		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
//	}

}

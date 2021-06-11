<?php
declare(strict_types=1);

defined ( 'BASEPATH' ) or exit ('No direct script access allowed');

class BaseControllerWeb extends CI_Controller
{

    protected $role = '';
    protected $userId = '';
    protected $name = '';
    protected $roleText = '';
    protected $global = array ();
    protected $lastLogin = '';

    private $header;

    public function __construct()
    {
		parent::__construct();
		$this->load->library('language', array('controller' => $this->router->class));
        $this->load->helper('cookie');
        $this->load->config('custom');

        $this->tiqsMainId = $this->config->item('tiqsId');
	}

    /**
     * Takes mixed data and optionally a status code, then creates the response
     *
     * @access public
     * @param array|NULL $data
     *        	Data to output to the user
     *        	running the script; otherwise, exit
     */
    public function response(array $data = NULL): void
    {
        $this->output
            ->set_status_header( 200 )
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display ();
        exit ();
    }

    /**
     * This function used to check the vendor is logged in or not
     */
    public function isLoggedIn()
    {
        // prevent buyer to have access to vendor backoffice
        if (empty($_SESSION['userId']) || empty($_SESSION['role']) || $this->isBuyer()) {
            session_destroy();
            redirect ('login');
            exit();
        } else {
            $this->role = $this->session->userdata('role');
            $this->userId = $this->session->userdata('userId');
            $this->name = $this->session->userdata('name');
            $this->roleText = $this->session->userdata('roleText');
            $this->lastLogin = $this->session->userdata('lastLogin');
            $this->global['name'] = $this->name;
            $this->global['role'] = $this->role;
            $this->global['role_text'] = $this->roleText;
            $this->global['last_login'] = $this->lastLogin;
        }
    }

    public function isBuyer(): bool
    {
        return !empty($_SESSION['buyerId']);
    }

    /**
     * This function is used to check the access
     */
    public function isAdmin(): bool
    {
        // !!!! TO DO CHECK THIS WITH PETER !!!!
        // if ($this->role != ROLE_ADMIN) {
        //     return true;
        // } else {
        //     return false;
        // }
        return ($this->role !== ROLE_ADMIN) ? true : false;
    }

    public function isManager(): bool
    {
        return ($this->role === ROLE_MANAGER) ? true : false;
    }

    /**
     * This function is used to check the access
     */
    public function isTicketter(): bool
    {
        return ($this->role !== ROLE_ADMIN || $this->role !== ROLE_MANAGER) ? true : false;
    }

    /**
     * This function is used to load the set of views
     */
    public function loadThis(): void
    {
        $this->global ['pageTitle'] = 'tiqs : Access Denied';
        $this->load->view ('includes/header', $this->global);
        $this->load->view ('access');
        // $this->load->view ('includes/footer');
    }

    /**
     * This function is used to logged out user from system
     */
    public function logout()
    {
        session_destroy();
        redirect('login');
        exit();
    }

    /**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    public function loadViews(string $viewName = "", $headerInfo = NULL, $pageinfo= NULL, $footerInfo = NULL, $Headermenu = NULL, $language = ''): void
    {        
        if ($language) {
            $this->session->set_userdata('site_lang', $language);
        } else {
            $this->setSessionDefaultLang();
        }
        
        $this->setBaseUrl();
        $this->setHeader($Headermenu);
        $this->setView($viewName);
        $headerInfo['viewName'] = explode('/', $viewName);
        $headerInfo['viewName'] = $headerInfo['viewName'][count($headerInfo['viewName']) - 1];
        $this->load->view($this->header, $headerInfo);
        $this->load->view($viewName, $pageinfo);

        if($Headermenu!='none') {
        	if(is_null($footerInfo)){
        		$footerInfo = "footerweb";
            }
			$this->load->view('includes/'.$footerInfo, $pageinfo);
        }
        // $this->tiqstats($viewName);
    }

    private function setSessionDefaultLang(): void
    {
		// the language selected should be stored in a session
		// the defaukt language is the browser language
		// selecting another language should overwrite the default language
		// need to set in the languages a browser default option

        $defaultlanguage = $this->getDefaultLanguage(); // browser language
		$language = '';
		$language = get_cookie("language");
		// even uit gezet teste!!!
		if ($language!=''){
			$defaultlanguage=$language; // from the cookie
		}
        $this->session->set_userdata('site_lang', $defaultlanguage); // from the browser
    }

    private function setBaseUrl(): void
    {
        $this->baseUrl = base_url();
    }

    private function setHeader($Headermenu): void
    {
    	if($Headermenu==NULL){
			if (isset($_SESSION['userId']) && isset($_SESSION['role'])) {
				if ($this->session->userdata('role') === '1') {
					$this->header = 'includes/headerwebloginadmin';
				} elseif ($this->session->userdata('role') === '2') {
					if ($this->session->userdata('dropoffpoint') === '0') {
						$this->header = 'includes/headerwebloginuser';
						// Hier moeten we een aparte menu lay-out voor maken.
					} elseif ($this->session->userdata ('dropoffpoint') === '1') {
						if (!empty($Headermenu)){
							$this->header = 'includes/'. $Headermenu;
						}
						else {
							$this->header = 'includes/headerwebloginhotel';
						}
					}
				} elseif ($this->session->userdata ( 'role' ) === '4') {
					$this->header = 'includes/headerweblogintranslator';
				}
			} else {
				$this->header = 'includes/headerweb';
			}
    	}
    	else {
			$this->header = 'includes/'.$Headermenu;
		}

    }

    private function setView(string $view): void
    {
        $this->view = $view;
    }

    public function generateUniqueToken(int $length): string
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    /**
     * This function used provide the pagination resources
     * @param {string} $link : This is page link
     * @param {number} $count : This is page count
     * @param {number} $perPage : This is records per page limit
     * @return {mixed} $result : This is array of records and pagination data
     */
    public function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) {
        $this->load->library ( 'pagination' );

        $config ['base_url'] = base_url () . $link;
        $config ['total_rows'] = $count;
        $config ['uri_segment'] = $segment;
        $config ['per_page'] = $perPage;
        $config ['num_links'] = 5;
        $config ['full_tag_open'] = '<nav><ul class="pagination">';
        $config ['full_tag_close'] = '</ul></nav>';
        $config ['first_tag_open'] = '<li class="arrow">';
        $config ['first_link'] = 'First';
        $config ['first_tag_close'] = '</li>';
        $config ['prev_link'] = 'Previous';
        $config ['prev_tag_open'] = '<li class="arrow">';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_link'] = 'Next';
        $config ['next_tag_open'] = '<li class="arrow">';
        $config ['next_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a href="#">';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['last_tag_open'] = '<li class="arrow">';
        $config ['last_link'] = 'Last';
        $config ['last_tag_close'] = '</li>';

        $this->pagination->initialize ( $config );
        $page = $config ['per_page'];
        $segment = $this->uri->segment ( $segment );

        return array (
            "page" => $page,
            "segment" => $segment
        );

    }

	public function getDefaultLanguage() {
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
			return $this->parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		else
			return $this->parseDefaultLanguage(NULL);
	}

    public function parseDefaultLanguage($http_accept, $deflang = "en")
    {
		if(isset($http_accept) && strlen($http_accept) > 1)  {
			# Split possible languages into array
			$x = explode(",",$http_accept);
			foreach ($x as $val) {
				#check for q-value and create associative array. No q-value means 1 by rule
				if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
					$lang[$matches[1]] = (float)$matches[2];
				else
					$lang[$val] = 1.0;
			}

			#return default language (highest q-value)
			$qval = 0.0;
			foreach ($lang as $key => $value) {
				if ($value > $qval) {
					$qval = (float)$value;
					$deflang = $key;
				}
			}
		}
		// we need to create here an array of supported languages.
		// other wise we get empty strings. This array need to be the same as the Switch languages...
		$languageID=substr($deflang,0,2);
//		$this->phpAlert($deflang);
//		$this->phpAlert($languageID);
		return strtolower($languageID);
	}

    public function phpAlert($msg): void
    {
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}

	public function tiqstats(string $viewName): void
	{
//        $this->stats_model->ipaddress = $_SERVER['REMOTE_ADDR'];
//        $this->stats_model->view = $viewName;
//        $stats = $this->stats_model->getIpInfo();
//        $this->stats_model->setObject($stats)->insertStat();
    }
}

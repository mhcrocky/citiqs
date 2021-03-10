<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Language {
	var $language    = array();
	var $is_loaded    = array();
	var $idiom;
	var $set;
	var $controller;

	var $line;
	var $CI;

	public function __construct(array $params)
	{
		log_message('info', 'Language Class Initialized');
		$this->controller = $params['controller'];

	}

	/**
	 * Load a language file
	 *
	 * @access    public
	 * @param    mixed    the name of the language file to be loaded. Can be an array
	 * @param    string    the language (english, etc.)
	 * @return    mixed
	 */
	function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = true, $alt_path = '')
	{
		$this->idiom = $idiom;

		$database_lang =  $this->_get_from_db();
		if ( ! empty( $database_lang ) )
			$lang = $database_lang;
		else
			// when no language is foudn this is becoming a big issue.
			// show_error('Unable to load the requested language file: language/'.$langfile);
		{

		}

		$this->is_loaded[] = $langfile;
		$this->language = $database_lang;

		log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}

	/**
	 * Load a language from database
	 *
	 * @access    private
	 * @return    array
	 */
	private function _get_from_db()
	{
		$return = array();

		$CI =& get_instance();

		$CI->db->select   ('key, text, language, langID');
		$CI->db->from     ('tbl_language');
		$CI->db->where    ('language', $this->idiom);
//        $CI->db->where    ('controller', $this->controller);

		$query = $CI->db->get()->result();

		foreach ( $query as $row )
		{
			$return[$row->langID] = $row->text;
		}

		unset($CI, $query);
		return $return;
	}

	/**
	 * Language line
	 *
	 * Fetches a single line of text from the language array
	 *
	 * @param	string	$line		Language line key
	 * @param	bool	$log_errors	Whether to log an error message if the line is not found
	 * @return	string	Translation
	 */


	public function line($langID, $line, $log_errors = TRUE)
	{

		$value = isset($this->language[$langID]) ? $this->language[$langID] : FALSE;
		$CII =& get_instance();
 
		if($value === FALSE && $log_errors === TRUE)
		{
			$value = $this->translate('en',$this->idiom, $line);
			if(!$value=="") {
				$translation = array(
					'key' => $line,
					'language' => $this->idiom,
					'text' => $value,
					'controller' => $this->controller,
					'langID' => $langID
				);
				try {
					if ($CII->db->insert('tbl_language', $translation)) {
						return $value;
					} else {
						$translation = array(
							'key' => $line,
							'langid' => $langID
						);
						$CII->db->where('langID', $langID);
						$CII->db->update('tbl_language', $translation);
					}
				} catch (Exception $ex) {
					return -1;
				}
			}
		}
		$translation = array(
			'key' => $line,
		);
		// var_dump($value);
		// die('111');
		//		 $CII->db->where('langID', $langID);
		//		 $CII->db->update('tbl_language', $translation);

		return $value;
	}

	public function tline($line, $log_errors = TRUE)
	{

		$value = isset($this->language[$line]) ? $this->language[$line] : FALSE;
		$CII =& get_instance();

		if($value === FALSE && $log_errors === TRUE)
		{
			$value = $this->translate('en',$this->idiom, $line);
			if(!$value=="") {
				$translation = array(
					'key' => $line,
					'language' => $this->idiom,
					'text' => $value,
					'controller' => $this->controller,
					'langID' => $line
				);
				try {
					if ($CII->db->insert('tbl_language', $translation)) {
						return $value;
					} else {
						$translation = array(
							'key' => $line,
							'langid' => $line
						);
						$CII->db->where('langID', $line);
						$CII->db->update('tbl_language', $translation);
					}
				} catch (Exception $ex) {
					return -1;
				}
			}
		}
		$translation = array(
			'key' => $line,
		);
		// var_dump($value);
		// die('111');
		//		 $CII->db->where('langID', $langID);
		//		 $CII->db->update('tbl_language', $translation);

		return $value;
	}

	public static function translate($source, $target, $text)
	{
		$translation="";
		if($text==""){
			return $translation;
		}
		// Request translation
		$response = self::requestTranslation($source, $target, $text);
		return $response;
//		$translation = self::getSentencesFromJSON($response);
//		return $translation;
	}

	protected static function requestTranslation($source, $target, $text)
	{
		$source ='';
		if($target=='english'){ $target='en';};
		$apiKey = 'AIzaSyA6W1RAd6BCKqfdwwLeyLkfGe6pxY7oOk4';
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source='. rawurlencode($source) .'&target=' . rawurlencode($target);

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handle);
		$responseDecoded = json_decode($response, true);
		$responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);      //Here we fetch the HTTP response code
		curl_close($handle);

		if($responseCode != 200) {
			echo $source;
		}
		else {
			return $responseDecoded['data']['translations'][0]['translatedText'];
		}

	}

	protected static function getSentencesFromJSON($json)
	{
		$sentences = "";

		try {
			$sentencesArray = json_decode($json, true);

			if ($sentencesArray) {
				// can not translate.....
				// throw new \Exception("Google detected unusual traffic from your computer network, try again later (2 - 48 hours)");
				try {
					foreach ($sentencesArray["sentences"] as $s) {
						$sentences .= isset($s["trans"]) ? $s["trans"] : '';
					}
				} catch (Exception $e) {
				log_message(0,$e->getMessage());
				var_dump($e);
				}
			}

			return $sentences;
		}
		catch (Exception $e) {
			var_dump($e);
		}

		return $sentences;
	}


}

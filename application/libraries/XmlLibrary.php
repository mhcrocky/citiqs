<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class HttpClient {

    private $url = NULL;
    private $headers = array();
    private $timeout = NULL;
    private $verifyPeer = TRUE;
    private $verifyHost = 2;
    private $certificatePEM = __DIR__."/cacert.pem";

    public function __construct($url) {
        $this->url = $url;
    }

    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }

    public function setPeerVerified($value = TRUE) {
        $this->verifyPeer = $value;
    }

    public function addHeader($key, $value) {
        $this->headers[] = $key . ": " . $value;
    }

    public function send($data) {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyHost);
//        curl_setopt($ch, CURLOPT_CAINFO, $this->certificatePEM);
//        curl_setopt($ch, CURLOPT_CAPATH, $this->certificatePEM);
//        if ($this->headers != NULL) {
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//        }
//        $content = trim(curl_exec($ch));
//        curl_close($ch);
//        if (isset($content)) {
//            return $content;
//        }
		$verbosPath = FCPATH.'verboseOut.txt';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_VERBOSE, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyHost);
		curl_setopt($ch, CURLOPT_CAINFO, $this->certificatePEM);
		curl_setopt($ch, CURLOPT_CAPATH, $this->certificatePEM);
		if ($this->headers != NULL) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		}

		curl_setopt($ch, CURLOPT_STDERR,$f = fopen($verbosPath, "w+"));

		$content = trim(curl_exec($ch));
		curl_close($ch);
		if (isset($content)) {
			return $content;
		}
		return NULL;

    }

}


class XmlClient extends HttpClient {

    public function sendRequest(XmlRequest $req) {
        $res = $this->send($req->__toString());
        $xmlRes = new XmlResponse($res);
        if ($xmlRes->valid()) {
            return $xmlRes;
        }
        return NULL;
    }

    public function send($data) {
        if (is_object($data) && get_class($data) == 'XmlRequest') {
            return $this->sendRequest($data);
        }
        return parent::send($data);
    }

}

class XmlRequest {

    private $xmlObject = NULL;

    public function __construct($xmlString) {
        libxml_use_internal_errors(TRUE);
        try {
            $this->xmlObject = new SimpleXmlElement($xmlString);
        } catch (Exception $e) {
            $this->xmlObject = NULL;
        }
    }

    public function valid() {
        return $this->xmlObject != NULL;
    }

    public function __toString() {
        return $this->xmlObject->asXML();
    }

}

class XmlResponse {

    private $xmlObject = NULL;

    public function __construct($xmlString) {
        libxml_use_internal_errors(TRUE);
        try {
            $this->xmlObject = new SimpleXmlElement($xmlString);
        } catch (Exception $e) {
            $this->xmlObject = NULL;
        }
    }

    public function valid() {
        return $this->xmlObject != NULL;
    }

    public function __toString() {
        return $this->xmlObject->asXML();
    }

    public function getValue($xpath) {
        $nodes = $this->xmlObject->xpath($xpath);
        if (is_array($nodes) && sizeOf($nodes) > 0) {
            return (string) $nodes[0];
        }
        return NULL;
    }

}

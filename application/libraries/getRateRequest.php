<?php
declare(strict_types=1);

require_once  APPPATH . '/helpers/google_helper.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class GetRateRequest
{
   private $username = DHL_USERNAME;
   private $password = DHL_PASSWORD;
   private $nonce = DHL_NONCE;
   private $created = DHL_CREATED;
   private $dropOffType = "REQUEST_COURIER";
   private $unitOfMeasurement = "SI";
   private $content = "DOCUMENTS";
   private $declaredValue = "0000000000";
   private $declaredValueCurrencyCode = "EUR";
   private $paymentInfo = "CFR";
   private $serviceType = ""; // INS
   private $serviceValue =  "0";
   private $currencyCode = "EUR";
   private $requestValueAddedServices = "N";
   private $account =  "966049846";
   private $url = 'https://wsbexpress.dhl.com/sndpt/expressRateBook';
   private $timeout = 60000;
   private $headers = [
      'Content-Type' => 'text/xml;charset=UTF-8',
      'SoapAction' => '*',
   ];

   // BY DEFAULT current date + 1
   public $shipTimestamp;

   //label info for tbl_label
   public $shipperStreetLines;
   public $shipperCity;
   public $shipperPostalCode;
   public $shipperCountryCode;
   public $shipperGmtOffset;

   public $recipientStreetLines;
   public $recipientCity;
   public $recipientPostalCode;
   public $recipientCountryCode;

   public $packageWeight;
   public $packageLength;
   public $packageWidth;
   public $packageHeight;

   public function __construct(array $label, string $date = '')
   {
		$this->shipperStreetLines = $label['finderAddress'] . ' ' . $label['finderAddressa'];
		$this->shipperCity = $label['finderCity'];
		$this->shipperPostalCode = $label['finderZipcode'];
      $this->shipperCountryCode = $label['finderCountry'];
      $this->shipperGmtOffset = $label['finderGmtOffSet'];

		$this->recipientStreetLines = $label['claimerAddress'] . ' ' . $label['claimerAddressa'];
		$this->recipientCity = $label['claimerCity'];
		$this->recipientPostalCode = $label['claimerZipcode'];
		$this->recipientCountryCode = $label['claimerCountry'];

		$this->packageWidth  = $label['labelDclw'];
		$this->packageLength = $label['labelDcll'];		
		$this->packageHeight = $label['labelDclh'];
      $this->packageWeight = $label['labelDclwgt'];

      $this->setShipTimestamp($date);
   }

   public function setDropOffType(string $dropOffType): GetRateRequest
   {
      $this->dropOffType = $dropOffType;
      return $this;
   }

   public function setUnitOfMeasurement(string $unitOfMeasurement): GetRateRequest
   {
      $this->unitOfMeasurement = $unitOfMeasurement;
      return $this;
   }

   public function setContent(string $content): GetRateRequest
   {
      $this->content = $content;
      return $this;
   }

   public function setDeclaredValue(string $declaredValue): GetRateRequest
   {
      $this->declaredValue = $declaredValue;
      return $this;
   }

   public function setDeclaredValueCurrencyCode(string $declaredValueCurrencyCode): GetRateRequest
   {
      $this->declaredValueCurrencyCode = $declaredValueCurrencyCode;
      return $this;
   }

   public function setPaymentInfo(string $paymentInfo): GetRateRequest
   {
      $this->paymentInfo = $paymentInfo;
      return $this;
   }

   public function setServiceType(string $serviceType): GetRateRequest
   {
      $this->serviceType = $serviceType;
      return $this;
   }

   public function setServiceValue(string $serviceValue): GetRateRequest
   {
      $this->serviceValue = $serviceValue;
      return $this;
   }

   public function setCurrencyCode(string $currencyCode): GetRateRequest
   {
      $this->currencyCode = $currencyCode;
      return $this;
   }

   public function setRequestValueAddedServices(string $requestValueAddedServices): GetRateRequest
   {
      $this->requestValueAddedServices = $requestValueAddedServices;
      return $this;
   }

   public function setAccount(string $account): GetRateRequest
   {
      $this->account = $account;
      return $this;
   }

   public function setUrl(string $url): GetRateRequest
   {
      $this->url = $url;
      return $this;
   }

   public function setTimeout(int $timeout): GetRateRequest
   {
      $this->timeout = $timeout;
      return $this;
   }

   public function setHeaders (array $headers): GetRateRequest
   {
      $this->headers = $headers;
      return $this;
   }

   public function setShipTimestamp(string $date = ''): GetRateRequest
   {
      $CI =& get_instance();
      $CI->load->helper('utility');
      $date = $date ? $date : date('Y-m-d h:i:s', strtotime('+2 days')); // "2019-11-26T12:00:00GMT-06:00"
      $date = Utility_helper::getMondayIwWeekendDay($date);      
      $date = $date . 'GMT' . $this->shipperGmtOffset;
      $this->shipTimestamp = str_replace(' ', 'T', $date);
      return $this;
   }

   public function send()
   {
      $client = new XmlClient($this->url);
      $client->setTimeout($this->timeout);
      if ($this->headers != NULL) {
         foreach ($this->headers as $key => $value) {
            $client->addHeader($key, $value);
         }
      }
      $this->response = $client->send(new XmlRequest($this->request()));
   }

   public function request()
   {
      return 
         '<?xml version="1.0" encoding="UTF-8"?>
         <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://scxgxtt.phx-dc.dhl.com/euExpressRateBook/RateMsgRequest" xmlns:ns2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:ns3="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <SOAP-ENV:Header>
               <ns2:Security SOAP-ENV:mustUnderstand="1">
                  <ns2:UsernameToken>
                     <ns2:Username>' . $this->username . '</ns2:Username>
                     <ns2:Password>' . $this->password . '</ns2:Password>
                     <ns2:Nonce>' . $this->nonce . '</ns2:Nonce>
                     <ns3:Created>' . $this->created . '</ns3:Created>
                  </ns2:UsernameToken>
               </ns2:Security>
            </SOAP-ENV:Header>
            <SOAP-ENV:Body>
               <RateRequest>
                  <ClientDetail />
                  <RequestedShipment>
                     <DropOffType>' . $this->dropOffType . '</DropOffType>
                     <Ship>
                        <Shipper>
                           <StreetLines>' . $this->shipperStreetLines . '</StreetLines>
                           <City>' . $this->shipperCity . '</City>
                           <PostalCode>' . $this->shipperPostalCode . '</PostalCode>
                           <CountryCode>' . $this->shipperCountryCode . '</CountryCode>
                        </Shipper>
                        <Recipient>
                           <StreetLines>' . $this->recipientStreetLines . '</StreetLines>
                           <City>' . $this->recipientCity . '</City>
                           <PostalCode>' . $this->recipientPostalCode . '</PostalCode>
                           <CountryCode>' . $this->recipientCountryCode . '</CountryCode>
                        </Recipient>
                     </Ship>
                     <Packages>
                        <RequestedPackages number="0">
                           <Weight>
                              <Value>' . $this->packageWeight . '</Value>
                           </Weight>
                           <Dimensions>
                              <Length>' . $this->packageLength . '</Length>
                              <Width>' . $this->packageWidth . '</Width>
                              <Height>' . $this->packageHeight . '</Height>
                           </Dimensions>
                        </RequestedPackages>
                     </Packages>
                     <ShipTimestamp>' . $this->shipTimestamp . '</ShipTimestamp>
                     <UnitOfMeasurement>' . $this->unitOfMeasurement . '</UnitOfMeasurement>
                     <Content>' . $this->content . '</Content>
                     <DeclaredValue>' . $this->declaredValue . '</DeclaredValue>
                     <DeclaredValueCurrecyCode>' . $this->declaredValueCurrencyCode . '</DeclaredValueCurrecyCode>
                     <PaymentInfo>' . $this->paymentInfo . '</PaymentInfo>
                     <SpecialServices>
                        <Service>
                           <ServiceType>' . $this->serviceType . '</ServiceType>
                           <ServiceValue>' . $this->serviceValue . '</ServiceValue>
                           <CurrencyCode>' . $this->currencyCode . '</CurrencyCode>
                        </Service>
                     </SpecialServices>
                     <RequestValueAddedServices>' . $this->requestValueAddedServices . '</RequestValueAddedServices>
                     <Account>' . $this->account . '</Account>
                  </RequestedShipment>
               </RateRequest>
            </SOAP-ENV:Body>
         </SOAP-ENV:Envelope>';
   }

   public function saveRequestToXml(string $folder): int
   {
      $xmlRequestFile  = $folder . date('Y-m-d H:i:s') . '_RQ_';
		$xmlRequestFile .= $this->shipperPostalCode . '_' . $this->shipperCountryCode . '_'; 
      $xmlRequestFile .= $this->recipientPostalCode . '_' . $this->recipientCountryCode . '.xml';
      return file_put_contents($xmlRequestFile, $this->request());
   }


   public function saveResponseToXml(string $folder): int
   {
      if (isset($this->response)) {
         $xmlResponseFile  = $folder. date('Y-m-d H:i:s') . '_RS_';
         $xmlResponseFile .= $this->shipperPostalCode . '_' . $this->shipperCountryCode . '_'; 
         $xmlResponseFile .= $this->recipientPostalCode . '_' . $this->recipientCountryCode . '.xml';
         return file_put_contents($xmlResponseFile,  $this->response->__toString());
      }
      return 0;      
   }

   public function setDomestic(): void
   {
      $this->domestic = 'D';
      if ($this->shipperCountryCode === $this->recipientCountryCode){ // domestic
		  $this->domestic = 'N'; // Domestic can ook een "7" zijn...
      }
      if ($this->shipperCountryCode !== $this->recipientCountryCode){ // europe
         $this->domestic = 'U';
      }
      if ($this->shipperCountryCode !== $this->recipientCountryCode){
         $this->domestic = 'D';
      }
   }     
}

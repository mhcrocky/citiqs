<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    Class Perfex_helper
    {

    	// NEED HELPER FOR EMPLOYEE

		//	array (size=15)
		//	'firstname' => string '4' (length=1)
		//	'email' => string 'a@gmail.com' (length=11)
		//	'hourly_rate' => string '0' (length=1)
		//	'phonenumber' => string '' (length=0)
		//	'facebook' => string '' (length=0)
		//	'linkedin' => string '' (length=0)
		//	'skype' => string '' (length=0)
		//	'default_language' => string '' (length=0)
		//	'email_signature' => string '' (length=0)
		//	'direction' => string '' (length=0)
		//	'departments' =>
		//	array (size=5)
		//	0 => string '1' (length=1)
		//	1 => string '2' (length=1)
		//	2 => string '3' (length=1)
		//	3 => string '4' (length=1)
		//	4 => string '5' (length=1)
		//	'send_welcome_email' => string 'on' (length=2)
		//	'fakeusernameremembered' => string '' (length=0)
		//	'fakepasswordremembered' => string '' (length=0)
		//	'password' => string '1' (length=1)
		//	'role' => string '18' (length=2)

        public static function prepareCustomer(object $user): array
        {
            return [
                'lostandfound_user_id' => $user->id,
                'company' => $user->username,
                'phonenumber' => $user->mobile,
                'address' => $user->address,
                'city' => $user->city,
                'zip' => $user->zipcode,
                'country' => $user->country,
                'email' => $user->email,
                'firstname' => $user->first_name,
                'lastname' => $user->second_name,
                
                'billing_street' => $user->address,
                'billing_city' => $user->city,                
                'billing_zip' => $user->zipcode,
                'billing_country' => $user->country,

                'shipping_street' => $user->address,
                'shipping_city' => $user->city,                
                'shipping_zip' => $user->zipcode,
                'shipping_country' => $user->country,
            ];
        }

        public static function apiCustomer(object $user): void
        {
            $url = PERFEX_API . 'customers/data';
			$headers = ['authtoken:' . PERFEX_API_KEY];
            $post = self::prepareCustomer($user);
            $response = Curl_helper::sendCurlPostRequest($url, $post, $headers);
            return;
        }

        public static function apiInovice(array $data): ?object
        {
            $data = json_encode($data);
//			var_dump($data);
//			die();
            $url = PERFEX_API . 'invoice/data';
			$headers = [
                'authtoken:' . PERFEX_API_KEY,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ];            
            
            $response = Curl_helper::sendCurlRawDataRequest($url, $data, $headers);
//			var_dump($data);
//			die();


            return ($response && $response->status) ? $response : null;
        }
    }

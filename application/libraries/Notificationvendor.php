<?php
	declare(strict_types=1);
	defined('BASEPATH') OR exit('No direct script access allowed');

	use SpryngApiHttpPhp\Client;
	use SpryngApiHttpPhp\Exception\InvalidRequestException;

	class Notificationvendor
	{

		public function sendVendorMessage(string $oneSignalId, int $orderId)
		{
			// die('line number 10 notification');
			$message = 'You have a new order at ' . date('Y-m-d H:i:s') . ' Order id is: ' . $orderId . '.';

			return $this->sendVendorMessageImproved($oneSignalId, $orderId, $message);

		}

		public function sendVendorMessageImproved(string $oneSignalId, int $orderId, string $message)
		{

			$content = array(
				"en" => $message
			);

			// $fields = array(
			// 	'app_id' => "8da54730-aa66-4a7f-8989-320413d88d09",
			// 	'include_player_ids' => array($oneSignalId),
			// 	'data' => array("foo" => "bar"),
			// 	'contents' => $content
			// );


			$fields = array(
				'app_id' => "8da54730-aa66-4a7f-8989-320413d88d09",
				'include_player_ids' => array($oneSignalId),
				'data' =>array("OrderId" => $orderId),
				'contents' => array("en" => $message),
				'android_channel_id' => "9599da1f-f8b9-4013-b6c5-5ddd34cc1b36",
				'ios_sound' => "sound.wav"
			);

			// {"app_id":"","include_player_ids":["860d0e99-db07-440e-a644-3f6217d2523a"],"data":{"OrderId":"112969"},"contents":{"en":"New order"},"launchUrl":null}
			// 74e6564a-e015-40b4-ac6d-03c8f7d6b793

			// var_dump($fields);
			// die();

			$fields = json_encode($fields);
			// print("\nJSON sent:\n");
			// print($fields);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$response = curl_exec($ch);
			curl_close($ch);

			// var_dump($response);
			return $response;
		}
		//	$response = sendMessage();
		//	$return["allresponses"] = $response;
		//	$return = json_encode( $return);
		//
		//	print("\n\nJSON received:\n");
		//	print($return);
		//	print("\n");

	}

<?php
    declare(strict_types=1);
    include APPPATH . '/libraries/ical/ICS.php';
    require APPPATH . '/libraries/phpqrcode/qrlib.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Ticketingemail_helper
    {
        public static function sendEmailReservation(array $reservations, $icsFile = false, $resend = false, $sendToSupport = false, $supportEmail = "support@tiqs.com", $templateId = false) : bool
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->helper('utility_helper');
            $CI->load->model('sendreservation_model');
            $CI->load->model('email_templates_model');

            $send_successfully = false;
            

            foreach ($reservations as $key => $reservation):
                $result = $CI->sendreservation_model->getEventTicketingData($reservation->reservationId);
                
                
                foreach ($result as $record) {
                    $customer = $record->customer;
                    $Spotlabel = $record->Spotlabel;
                    $eventDate = $record->eventdate;
                    $endDate = $record->EndDate;
                    $eventName = $record->eventname;
                    $eventVenue = $record->eventVenue;
                    $eventAddress = $record->eventAddress;
                    $eventCity = $record->eventCity;
                    $eventCountry = $record->eventCountry;
                    $eventZipcode = $record->eventZipcode;
				    $reservationId = $record->reservationId;
				    $ticketPrice = $record->price;
                    $ticketFee = $record->ticketFee;
                    $ticketId = $record->ticketId;
                    $ticketDescription = $record->ticketDescription;
				    $ticketQuantity = $record->numberofpersons;
                    $orderAmount = intval($ticketQuantity) * (floatval($record->price) + floatval($record->ticketFee));
                    $orderAmount = number_format($orderAmount, 2, '.', '');
                    $buyerName = $record->name;
                    $buyerEmail = $record->email;
				    $buyerMobile = $record->mobilephone;
				    $reservationset = $record->reservationset;
                    $orderId = $record->orderId;
				    $fromtime = $record->timefrom;
				    $totime = $record->timeto;
				    $paid = $record->paid;
				    $TransactionId = $record->TransactionID;
                    $voucher = $record->voucher;
                    $mailsend = $record->mailsend;
                    
                    if ($paid == 1 || $paid == 3) {
                        
                        $qrtext = $reservationId;

						// switch (strtolower($_SERVER['HTTP_HOST'])) {
						// 	case 'tiqs.com':
						// 		$file = '/home/tiqs/domains/tiqs.com/public_html/alfred/uploads/qrcodes/';
						// 		break;
						// 	case '127.0.0.1':
						// 		$file = 'C:/wamp64/www/alfred/alfred/uploads/qrcodes/';
						// 		break;
                        //     default:
                        //         $file = FCPATH . 'uploads/qrcodes/';
						// 		break;
						// }

						$SERVERFILEPATH = FCPATH . 'uploads/qrcodes/';
						$text = $qrtext;
						$folder = $SERVERFILEPATH;
						$file_name1 = $qrtext . ".png";
						$file_name = $folder . $file_name1;

						QRcode::png($text, $file_name, QR_ECLEVEL_H, 10);

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
								break;
							default:
                                $SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
                        }

                        $emailId =  ($templateId !== false) ?  $templateId : $record->emailId ;
                        
                        
						if($emailId) {
                            $emailTemplate = $CI->email_templates_model->get_emails_by_id($emailId);
                            
                            
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$CI->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
                                $dt = new DateTime('now');
                                $date = $dt->format('Y.m.d');
                                $mailtemplate = str_replace('[currentDate]', $buyerName, $mailtemplate);
                                $mailtemplate = str_replace('[orderId]', $orderId, $mailtemplate);
                                $mailtemplate = str_replace('[orderAmount]', $orderAmount, $mailtemplate);
                                $mailtemplate = str_replace('[buyerName]', $buyerName, $mailtemplate);
								$mailtemplate = str_replace('[buyerEmail]', $buyerEmail, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $buyerMobile, $mailtemplate);
                                $mailtemplate = str_replace('[eventName]', $eventName, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventDate)), $mailtemplate);
								$mailtemplate = str_replace('[eventVenue]', $eventVenue, $mailtemplate);
								$mailtemplate = str_replace('[eventAddress]', $eventAddress, $mailtemplate);
                                $mailtemplate = str_replace('[eventCity]', $eventCity, $mailtemplate);
								$mailtemplate = str_replace('[eventCountry]', $eventCountry, $mailtemplate);
								$mailtemplate = str_replace('[eventZipcode]', $eventZipcode, $mailtemplate);
								$mailtemplate = str_replace('[ticketDescription]', $ticketDescription, $mailtemplate);
								$mailtemplate = str_replace('[ticketPrice]', $ticketPrice, $mailtemplate);
                                $mailtemplate = str_replace('[price]', $ticketPrice, $mailtemplate);
								$mailtemplate = str_replace('[ticketQuantity]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[numberOfPersons]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', '', $mailtemplate);
                                $mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
                                $mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);


                                $fromEmail = 'support@tiqs.com';

                                if($templateId === false){
                                    $mailtemplate .= '<div style="width:100%;text-align:center;margin-top: 30px;">';
                                    $download_pdf_link = base_url() . "booking_events/pdf/" . $emailId . "/" . $reservationId;
                                    $mailtemplate .= '<a href="'.$download_pdf_link.'" id="pdfDownload" style="background-color:#008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Download as PDF</a>';
                                    $mailtemplate .= '</div>';
                                } else {
                                    $fromEmail = 'noreply@tiqs.com';
                                }


                                
								$subject = ($emailTemplate->template_subject) ? strip_tags($emailTemplate->template_subject) : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;

                                $icsContent = false;

                                if($icsFile){
                                    $ics = new ICS(array(
                                        'location' => $eventAddress . ', ' . $eventCity . ', ' . $eventCountry,
                                        'organizer' => 'TIQS:malito:support@tiqs.com',
                                        'description' => strip_tags($eventName),
                                        'dtstart' => date('Y-m-d', strtotime($eventDate)) . ' ' .$fromtime,
                                        'dtend' => date('Y-m-d', strtotime($endDate)) . ' ' .$totime,
                                        'summary' => strip_tags($eventName),
                                        'url' => $download_pdf_link
                                    ));
                                    
                                    $icsContent = $ics->to_string();
                                }

                                if($mailsend == 0 || $resend == true){
                                    if($sendToSupport){
                                        self::sendEmail($supportEmail, $subject, $mailtemplate, $icsContent);
                                    }

								    if(self::sendEmail($buyerEmail, $subject, $mailtemplate, $icsContent, $fromEmail)) {
                                        $file = FCPATH . 'application/tiqs_logs/messages.txt';
                                        
//                                        Utility_helper::logMessage($file, $mailtemplate);
                                        $send_successfully = true;
                                        $CI->sendreservation_model->editbookandpaymailsend($datachange, $reservationId);
                                    
                                    }

                                }
                            }
                        }
                    }
                }
            endforeach;

            return $send_successfully;
            
        }

        public static function getTemplates(array $reservations) : array
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->helper('utility_helper');
            $CI->load->model('sendreservation_model');
            $CI->load->model('email_templates_model');

            $templates = [];
            

            foreach ($reservations as $key => $reservation):
                $result = $CI->sendreservation_model->getEventTicketingData($reservation->reservationId);
                
                
                foreach ($result as $record) {
                    $customer = $record->customer;
                    $Spotlabel = $record->Spotlabel;
                    $eventDate = $record->eventdate;
                    $endDate = $record->EndDate;
                    $eventName = $record->eventname;
                    $eventVenue = $record->eventVenue;
                    $eventAddress = $record->eventAddress;
                    $eventCity = $record->eventCity;
                    $eventCountry = $record->eventCountry;
                    $eventZipcode = $record->eventZipcode;
				    $reservationId = $record->reservationId;
				    $ticketPrice = $record->price;
                    $ticketFee = $record->ticketFee;
                    $ticketId = $record->ticketId;
                    $ticketDescription = $record->ticketDescription;
				    $ticketQuantity = $record->numberofpersons;
                    $orderAmount = intval($ticketQuantity) * (floatval($record->price) + floatval($record->ticketFee));
                    $orderAmount = number_format($orderAmount, 2, '.', '');
                    $buyerName = $record->name;
                    $buyerEmail = $record->email;
				    $buyerMobile = $record->mobilephone;
				    $reservationset = $record->reservationset;
                    $orderId = $record->orderId;
				    $fromtime = $record->timefrom;
				    $totime = $record->timeto;
				    $paid = $record->paid;
				    $TransactionId = $record->TransactionID;
                    $voucher = $record->voucher;
                    $mailsend = $record->mailsend;
                    

                    $qrtext = $reservationId;


						$SERVERFILEPATH = FCPATH . 'uploads/qrcodes/';
						$text = $qrtext;
						$folder = $SERVERFILEPATH;
						$file_name1 = $qrtext . ".png";
						$file_name = $folder . $file_name1;

						QRcode::png($text, $file_name, QR_ECLEVEL_H, 10);

						switch (strtolower($_SERVER['HTTP_HOST'])) {
							case 'tiqs.com':
								$SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
							case '127.0.0.1':
								$SERVERFILEPATH = 'http://127.0.0.1/alfred/alfred/uploads/qrcodes/';
								break;
							default:
                                $SERVERFILEPATH = 'https://tiqs.com/alfred/uploads/qrcodes/';
								break;
                        }

                        $emailId = $record->emailId ;
 
                        
						if($emailId) {
                            $emailTemplate = $CI->email_templates_model->get_emails_by_id($emailId);
                            $mailtemplate = false;
                            if(file_exists(FCPATH . 'assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$CI->config->item('template_extension'))){
                                $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$CI->config->item('template_extension'));
                            }
                            
                            
                            $qrlink = $SERVERFILEPATH . $file_name1;
							if($mailtemplate) {
                                $dt = new DateTime('now');
                                $date = $dt->format('Y.m.d');
                                $mailtemplate = str_replace('[currentDate]', $buyerName, $mailtemplate);
                                $mailtemplate = str_replace('[orderId]', $orderId, $mailtemplate);
                                $mailtemplate = str_replace('[orderAmount]', $orderAmount, $mailtemplate);
                                $mailtemplate = str_replace('[buyerName]', $buyerName, $mailtemplate);
								$mailtemplate = str_replace('[buyerEmail]', $buyerEmail, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $buyerMobile, $mailtemplate);
                                $mailtemplate = str_replace('[eventName]', $eventName, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventDate)), $mailtemplate);
								$mailtemplate = str_replace('[eventVenue]', $eventVenue, $mailtemplate);
								$mailtemplate = str_replace('[eventAddress]', $eventAddress, $mailtemplate);
                                $mailtemplate = str_replace('[eventCity]', $eventCity, $mailtemplate);
								$mailtemplate = str_replace('[eventCountry]', $eventCountry, $mailtemplate);
								$mailtemplate = str_replace('[eventZipcode]', $eventZipcode, $mailtemplate);
								$mailtemplate = str_replace('[ticketDescription]', $ticketDescription, $mailtemplate);
								$mailtemplate = str_replace('[ticketPrice]', $ticketPrice, $mailtemplate);
                                $mailtemplate = str_replace('[price]', $ticketPrice, $mailtemplate);
								$mailtemplate = str_replace('[ticketQuantity]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[numberOfPersons]', $ticketQuantity, $mailtemplate);
                                $mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', '', $mailtemplate);
                                $mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
                                $mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);

                                $templates[] = $mailtemplate;

                                
                            }
                        }
                    
                }
            endforeach;

            return $templates;
            
        }

        private static function sendEmail($email, $subject, $message, $icsContent=false, $fromEmail = 'support@tiqs.com')
        {
            $configemail = array(
			    'protocol' => PROTOCOL,
			    'smtp_host' => SMTP_HOST,
			    'smtp_port' => SMTP_PORT,
			    'smtp_user' => SMTP_USER, // change it to yours
			    'smtp_pass' => SMTP_PASS, // change it to yours
			    'mailtype' => 'html',
			    'charset' => 'utf-8',
			    'smtp_crypto' => 'tls',
			    'wordwrap' => TRUE,
			    'newline' => "\r\n"
            );
            
            $config = $configemail;
		    $CI =& get_instance();
		    $CI->load->library('email', $config);
		    $CI->email->set_header('X-SES-CONFIGURATION-SET', 'ConfigSet');
		    $CI->email->set_newline("\r\n");
		    $CI->email->from($fromEmail);
		    $CI->email->to($email);
		    $CI->email->subject($subject);
		    $CI->email->message($message);
            if($icsContent){
                $CI->email->attach($icsContent, 'attachment', 'reservation.ics', 'text/calendar');
            }
            
            $CI->email->send();
            return $CI->email->clear(true);
        }

 
    }

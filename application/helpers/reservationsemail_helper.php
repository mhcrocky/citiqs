<?php
    declare(strict_types=1);
    include APPPATH . '/libraries/ical/ICS.php';
    require APPPATH . '/libraries/phpqrcode/qrlib.php';

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Reservationsemail_helper
    {
        public static function sendEmailReservation(array $reservations, $icsFile = false, $resend = false, $sendToSupport = false, $supportEmail = 'support@tiqs.com') : bool
        {
            $CI =& get_instance();
            $CI->load->config('custom');
            $CI->load->helper('utility_helper');
            $CI->load->model('sendreservation_model');
            $CI->load->model('bookandpayagenda_model');
            $CI->load->model('bookandpayspot_model');
            $CI->load->model('bookandpaytimeslots_model');
            $CI->load->model('email_templates_model');
            
            $send_successfully = false;

            foreach ($reservations as $key => $reservation):
                $result = $CI->sendreservation_model->getEventReservationData($reservation->reservationId);
                
                
                foreach ($result as $record) {
                    $customer = $record->customer;
                    $eventid = $record->eventid;
				    $eventdate = $record->eventdate;
				    $reservationId = $record->reservationId;
				    $spotId = $record->SpotId;
				    $price = $record->price;
                    $orderAmount = floatval($record->price) + floatval($record->reservationFee);
                    $orderAmount = number_format($orderAmount, 2, '.', '');
				    $Spotlabel = $record->Spotlabel;
				    $numberofpersons = $record->numberofpersons;
				    $name = $record->name;
				    $email = $record->email;
				    $mobile = $record->mobilephone;
				    $reservationset = $record->reservationset;
				    $fromtime = $record->timefrom;
				    $totime = $record->timeto;
			        $paid = $record->paid;
				    $timeSlotId = $record->timeslot;
				    $TransactionId = $record->TransactionID;
				    $voucher = $record->voucher;
                    $evenDescript = $record->ReservationDescription;
                    $orderId = $record->orderId;
                    $mailsend = $record->mailsend;
                    
                    if ($paid == 1 || $paid == 2) {
                        
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
								break;
                        }

                        $timeSlot = $CI->bookandpaytimeslots_model->getTimeSlot($timeSlotId);

                        $spot = $CI->bookandpayspot_model->getSpot($spotId);
                        $agenda = $CI->bookandpayagenda_model->getBookingAgendaById($spot->agenda_id);

                        $emailId = false;

                        if($timeSlot && $timeSlot->email_id != 0) {
                            $emailId = $timeSlot->email_id;
                        } elseif ($spot && $spot->email_id != 0) {
                            $emailId = $spot->email_id;
                        } elseif ($agenda && $agenda->email_id != 0) {
                            $emailId = $agenda->email_id;
                        }
                        
 
                        
						if($emailId) {
                            $emailTemplate = $CI->email_templates_model->get_emails_by_id($emailId);
                            
                            
                            $mailtemplate = file_get_contents(APPPATH.'../assets/email_templates/'.$customer.'/'.$emailTemplate->template_file .'.'.$CI->config->item('template_extension'));
                            $qrlink = $SERVERFILEPATH . $file_name1;
                            
							if($mailtemplate) {
                                $dt = new DateTime('now');
                                $date = $dt->format('Y.m.d');
                                //								$mailtemplate = str_replace('[voucherCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[currentDate]', $name, $mailtemplate);
                                $mailtemplate = str_replace('[orderAmount]', $orderAmount, $mailtemplate);
                                $mailtemplate = str_replace('[orderId]', $orderId, $mailtemplate);
                                $mailtemplate = str_replace('[buyerName]', $name, $mailtemplate);
                                $mailtemplate = str_replace('[buyerEmail]', $email, $mailtemplate);
                                $mailtemplate = str_replace('[buyerMobile]', $mobile, $mailtemplate);
								$mailtemplate = str_replace('[customer]', $customer, $mailtemplate);
								$mailtemplate = str_replace('[eventDate]', date('d.m.Y', strtotime($eventdate)), $mailtemplate);
								$mailtemplate = str_replace('[reservationId]', $reservationId, $mailtemplate);
								$mailtemplate = str_replace('[spotId]', $spotId, $mailtemplate);
								$mailtemplate = str_replace('[price]', $price, $mailtemplate);
                                $mailtemplate = str_replace('[ticketPrice]', $price, $mailtemplate);
								$mailtemplate = str_replace('[spotLabel]', $Spotlabel, $mailtemplate);
                                $mailtemplate = str_replace('[ticketQuantity]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[numberOfPersons]', $numberofpersons, $mailtemplate);
								$mailtemplate = str_replace('[startTime]', $fromtime, $mailtemplate);
								$mailtemplate = str_replace('[endTime]', $totime, $mailtemplate);
								$mailtemplate = str_replace('[timeSlot]', $timeSlotId, $mailtemplate);
								$mailtemplate = str_replace('[transactionId]', $TransactionId, $mailtemplate);
								$mailtemplate = str_replace('[WalletCode]', $voucher, $mailtemplate);
								$mailtemplate = str_replace('[QRlink]', $qrlink, $mailtemplate);
                                $mailtemplate .= '<div style="width:100%;text-align:center;margin-top: 30px;">';
                                $download_pdf_link = base_url() . "booking/pdf/" . $emailId . "/" . $reservationId;
                                $mailtemplate .= '<a href="'.$download_pdf_link.'" id="pdfDownload" style="background-color:#008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Download as PDF</a>';
                                $mailtemplate .= '</div>';
								$subject = ($emailTemplate->template_subject) ? strip_tags($emailTemplate->template_subject) : 'Your tiqs reservation(s)';
								$datachange['mailsend'] = 1;

                                $icsContent = false;

                                if($icsFile){
                                    $ics = new ICS(array(
                                        'organizer' => 'TIQS:malito:support@tiqs.com',
                                        'description' => strip_tags($evenDescript),
                                        'dtstart' => $eventdate .' '. $fromtime,
                                        'dtend' => $eventdate .' '. $totime,
                                        'summary' => strip_tags($evenDescript),
                                        'url' => $download_pdf_link
                                    ));
                                    
                                    $icsContent = $ics->to_string();
                                }

                                if($mailsend == 0 || $resend == true){
                                    if($sendToSupport){
                                        self::sendEmail($supportEmail, $subject, $mailtemplate, $icsContent );
                                    }

                                    

								    if(self::sendEmail($email, $subject, $mailtemplate, $icsContent)) {
                                        //$file = FCPATH . 'application/tiqs_logs/messages.txt';
                                        
                                        // Utility_helper::logMessage($file, $mailtemplate);
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

        public static function sendEmail($email, $subject, $message, $icsContent=false)
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
		    $CI->email->from('support@tiqs.com');
		    $CI->email->to($email);
		    $CI->email->subject($subject);
		    $CI->email->message($message);
            if($icsContent){
                $CI->email->attach($icsContent, 'attachment', 'reservation.ics', 'text/calendar');
            }
            
            $CI->email->send();
            $CI->email->clear(true);
            return true;
        }

 
    }

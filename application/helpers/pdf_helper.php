<?php
    declare(strict_types=1);

    require APPPATH . '/libraries/Pdf.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Pdf_helper
    {

        public static function HtmlToPdf($html)
        {
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'a4', true, 'UTF-8', true);


            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Tiqs');
            $pdf->SetTitle('Reservation');
            
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
            // old values
            // $pdf->SetHeaderMargin(10);
            // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // test values
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            
            // set auto page breaks
            
            
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
            // add a page
            $pdf->AddPage();
            

            $pdf->writeHTML($html, false, false, true, false, '');
//			$pdf->writeHTML($html);
            
            // reset pointer to the last page
            $pdf->lastPage();
            //Close and output PDF document
            
            $pdf->Output(APPPATH . 'reservation.pdf', 'FD');
            unlink(APPPATH . 'reservation.pdf');
        }
        
    }

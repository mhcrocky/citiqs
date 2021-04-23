<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        $this->SetTextColor(209,183,49);
        $this->Ln(5);        
        $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
  
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
  
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */

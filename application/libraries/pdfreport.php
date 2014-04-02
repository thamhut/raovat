<?php
require_once(dirname(__FILE__).'/tcpdf/config/lang/eng.php');
require_once(dirname(__FILE__).'/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
	//Page header
	/*public function Header() {
		// full background image
		// store current auto-page-break status
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		$img_file = K_PATH_IMAGES.'logo.png';
		$this->Image($img_file, 15, 105, 170, 80, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}*/
	
	public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);

        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $html = '<table style="border-bottom:5px solid #ccc;" cellpadding="3" cellspacing="0">
        <tr>
        	<td width="145">
	        	<ul>
	        		<li><span color="#ff9900">W</span>: www.admicro.vn</li>
	        		<li><span color="#ff9900">E</span>: contact@admicro.vn</li>
	        	</ul>
        	</td>
        	<td width="180">
	        	<ul>
	        		<li><span color="#ff9900">T</span>: (84 4) 3974 3410 ext: 843</li>
	        		<li><span color="#ff9900">F</span>: (84 4) 3974 3413</li>
	        	</ul>
        	</td>
        	<td width="280">
	        	<ul>
	        		<li><span color="#ff9900">A</span>: Level 22, Vincom B Tower, 191 Ba Trieu, Hai Ba Trung Dist, Ha Noi</li>
	        	</ul>
        	</td>
        	<td width="40">
        		<!-- <img src="'.base_url().'app/libraries/tcpdf/images/Logo_PDF.jpg" border="0"/> -->
        	</td>
        </tr>
        </table>
        ';
        
        $this->WriteHTML($html, false, false, true, false, '');
    }
    
}

class pdfreport
{
	var $_font = 'freeserifi';
	function setFont($font)
	{
		$this->_font = $font;
	}
   function html2pdf($html, $filename = 'admarket.pdf')
   {
		// create new PDF document
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		/*$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 006');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		//$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont($this->_font, '', 10);
		
		// add a page
		$pdf->AddPage();

		// output the HTML content
		$pdf->writeHTML($this->process_images($html), true, false, true, false, '');
		
		//Close and output PDF document
		$pdf->Output($filename, 'I');
		
		//============================================================+
		// END OF FILE                                                
		//============================================================+

   }
   
	function process_images($text){
    	$html = $text;
		$pattern = '/<img[^>]+\>/i';
   		$matches= '';
   		//Xoa cac text truoc <img de lay dung
   		if(substr($text, 0, 4) != '<img'){
   			$index = strpos($text, '<img');
   			$text = substr($text, $index - 1, strlen($text) - $index);
   		}
   		
    	preg_match_all($pattern, $text, $matches);
    	
    	foreach ($matches[0] as $img)
    	{
    		$pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
	   		$matches2 = '';
	    	preg_match_all($pattern, $img, $matches2);
	    	$img_src = $matches2[1][0];
	    	if(!$this->image_remote_exists($img_src))
	    		$html = str_replace($img, '', $html);
    	}
    	return $html;
	}
	
	function image_remote_exists($url)
	{
		if(@fclose(@fopen(urldecode($url), 'r'))) return true;
		else return false;
	}
}
?>
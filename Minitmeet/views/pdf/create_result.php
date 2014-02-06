<?php 

date_default_timezone_set('UTC');
//require('fpdf/fpdf.php');

class PDF_result extends Fpdf {
	public $creator;
	public $time;
	public $logo;
	function __construct ($cr='',$tim='',$img='', $orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
		$this->FPDF($orientation, $unit, $format);
		$this->SetTopMargin($margin);
		$this->SetLeftMargin($margin);
		$this->SetRightMargin($margin);
		
		$this->SetAutoPageBreak(true, $margin);
		$this->creator =$cr;
		$this->time =$tim;
		$this->logo=$img;
	}
	
	function Header () {
	     $this->Image($this->logo,40,15,250);
	     $this->SetFont('Arial', 'U', 18);
$this->Cell(0, 40, "Meeting Minutes",'','','R');
$this->Ln(60);
//$pdf->SetX(340);
$this->SetFont('Arial', '', 10);
$this->Cell(0,15, "Created By  : ".$this->creator,'','','R');
$this->Ln(20);
//$pdf->SetX(340);
$this->SetFont('Arial', '', 10);
$this->Cell(0, 15, "Meeting Date/Time : ".$this->time,'','','R');
	     $this->Ln(80);
/*$this->SetFont('Arial', 'U', 18);
$this->Cell(0, 40, "Meeting Minutes",'','','R');
$this->Ln(60);
$this->SetFont('Arial', '', 10);
$this->Cell(0,15, "Created By  : Abdullah Bashir",'','','R');
$this->Ln(20);*/
	//	$this->SetFont('Arial', 'B', 20);
	//	$this->SetFillColor(36, 96, 84);
	//	$this->SetTextColor(225);
	//	$this->Cell(0, 30, "YouHack MCQ Results", 0, 1, 'C', true);
	}
	
 function Footer()
{
    //Position at 1.5 cm from bottom
   /* $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Generated at YouHack.me',0,0,'C');*/
}

	
function Generate_Table($subjects, $marks) {
	$this->SetFont('Arial', 'B', 12);
	$this->SetTextColor(0);
//	$this->SetFillColor(94, 188, z);
$this->SetFillColor(94, 188, 225);
	$this->SetLineWidth(1);
	$this->Cell(427, 25, "Subjects", 'LTR', 0, 'C', true);
	$this->Cell(100, 25, "Marks", 'LTR', 1, 'C', true);
	 
	$this->SetFont('Arial', '');
	$this->SetFillColor(238);
	$this->SetLineWidth(0.2);
	$fill = false;
	
	for ($i = 0; $i < count($subjects); $i++) {
		$this->Cell(427, 20, $subjects[$i], 1, 0, 'L', $fill);
		$this->Cell(100, 20,  $marks[$i], 1, 1, 'R', $fill);
		$fill = !$fill;
	}
	$this->SetX(367);
	//$this->Cell(100, 20, "Total", 1);
//	$this->Cell(100, 20,  array_sum($marks), 1, 1, 'R');
}
	
	
	
	
	
	
}

$creator = $_POST['creator'];
$time = $_POST['time'];
$title = $_POST['title'];
$agenda = $_POST['agenda'];
$attendee = $creator;
foreach ($attendees as $contact) {
	if($contact->cname!=''){
		$attendee = $attendee.', '.$contact->cname;
	}
}

$pdf = new PDF_result($creator,$time,'http://www.d.xamsco.com/img/logo.png');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
//$pdf->SetY(100);
if($title != ''){
	$pdf->Cell(100, 13, $title);
}else{
	$pdf->Cell(100, 13, "The meeting title is missing");
}
$pdf->Ln(50);

$pdf->SetFillColor(58, 104, 210);
$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(255);
$pdf->Cell(0, 25, "Meeting Agenda", 'LTR', 0, 'L', true);
$pdf->Ln(25);
$pdf->SetFillColor(255);
//$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
//$pdf->SetMargins(30,30,30);
if($agenda != ''){
	$pdf->MultiCell(0, 15, $agenda, 'LRB', 'L');
}else{
	$pdf->MultiCell(0, 15, "The agenda for this meeting is missing", 'LRB', 'L');
}
$pdf->Ln(50);

$pdf->SetFillColor(58, 104, 210);
$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(255);
$pdf->Cell(0, 25, "Meeting Attendees", 'LTR', 0, 'L', true);
$pdf->Ln(25);
$pdf->SetFillColor(255);
//$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
//$pdf->SetMargins(30,30,30);
$pdf->MultiCell(0, 15, $attendee, 'LRB', 'L');


$pdf->Ln(50);

$pdf->SetFillColor(58, 104, 210);
$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(255);
$pdf->Cell(0, 25, "Meeting Notes", 'LTR', 0, 'L', true);
$pdf->Ln(25);
$pdf->SetFillColor(255);
//$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
//$pdf->SetMargins(30,30,30);
if(empty($notes_meeting)){$pdf->MultiCell(0, 25, "No notes have been recorded for this meeting." , 'LRB', 'L');}
foreach ($notes_meeting as $notes) {
	//if($notes->type=='-1'){
				$pdf->MultiCell(0, 25, $notes->description , 'LRB', 'L');		
	//}
}
//$pdf->MultiCell(0, 25, "Meeting Attendees", 'LRB', 'L');
//$pdf->Ln();
//$pdf->MultiCell(0, 25, "Meeting Attendees", 'LRB','L');
$pdf->Ln(50);

$pdf->SetFillColor(58, 104, 210);
$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(255);
$pdf->Cell(0, 25, "Action Items", 'LTR', 0, 'L', true);
$pdf->Ln(25);
$pdf->SetFillColor(255);
//$pdf->SetLineWidth(1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
//$pdf->SetMargins(30,30,30);
if(empty($action_meeting)){$pdf->MultiCell(0, 25, "No actions have been recorded for this meeting." , 'LRB', 'L');}
foreach ($action_meeting as $action) {
	if($action->type=='0'){
		$pdf->SetFont('Arial', '', 10);
		$pdf->SetTextColor(0);
		$pdf->MultiCell(0, 25, $action->description , 'LTR', 'L');	
	}else{
		$pdf->SetFont('Arial', '', 10);
		$pdf->SetTextColor(0);
		$pdf->MultiCell(0, 25, $action->description , 'LTR', 'L');
		$contacts_name = DB::table('contacts')->where('contactsID', '=' , $action->type)->where('user_id', '=' , Auth::user()->id)->first('cname'); 
		$pdf->SetFont('Arial', 'I', 8);
		$pdf->SetTextColor(153);
		$pdf->MultiCell(0, 25, "Assigned To: ".$contacts_name->cname , 'LRB', 'L');	
	}
}

$pdf->Output('public/result.pdf', 'F');




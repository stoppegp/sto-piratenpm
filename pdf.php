<?php

require('FPDF/fpdf.php');



class PDF extends FPDF
{

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",'<br>',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}
function SetStyle($tag, $enable)
{
	// Modify style and select corresponding font
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function Header()
{
    // Position at 1.5 cm from bottom
    // Arial italic 8
    $this->SetMargins(0,0,0);
    $this->SetFont('Arial','I',8);
    // Page number
    $this->SetY(0);
    
$this->SetFont('Arial','B',14);
$this->SetFillColor(255,166,64);
$this->Cell(0,1,'',0,1,'L',true);
$this->Cell(0,28,'       '.$std_pdf_header,0,1,'L',true);
$this->SetFillColor(0,0,0);

$this->Cell(0,1,'',0,1,'L',true);
$this->Image('std/logo.png',140,2,50);
$this->SetMargins(10,10,10);
$this->Cell(0,10,'',0,1,'L',false);
}

function Footer()
{
    // Position at 1.5 cm from bottom
    // Arial italic 8
    $this->SetMargins(0,0,0);
    $this->SetFont('Arial','I',8);
    // Page number
    $this->SetY(-32);
    
    $this->Cell(0,1,'',0,1,'L',false);
$this->SetFillColor(0,0,0);

$this->Cell(0,1,'',0,1,'L',true);
$this->SetFillColor(255,166,64);

    $this->Cell(0,30,'Seite '.$this->PageNo().'/{nb}',0,0,'R', true);
$this->SetXY(10,-29);
$this->MultiCell(60,5,$_SESSION['ansprechpartner1']);
$this->SetXY(70,-29);
$this->MultiCell(60,5,$_SESSION['ansprechpartner2']);
$this->SetXY(130,-29);
$this->MultiCell(60,5,$_SESSION['ansprechpartner3']);
$this->SetMargins(10,10,10);
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 35);
$pdf->SetMargins(0,0,0);
$pdf->AddPage();


$pdf->SetMargins(10,10,10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5, $_SESSION['datum'],0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Write(5, $_SESSION['titel']);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',12);
//$text = file_get_contents('text.html');
$pdf->WriteHTML($_SESSION['text']);
$pdf->Ln();

$pdf->Output("out/".session_id()."/PM-Piraten.pdf", "F");
?>
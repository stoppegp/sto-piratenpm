<?php

require('FPDF/fpdf.php');
require('FPDI/fpdi.php');



class PDF extends FPDI
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
    $this->AddFont('verdana', '', 'VERDANA.php');
    $this->AddFont('verdana', 'b', 'VERDANAB.php');
    $this->SetTopMargin(15);
    $this->SetRightMargin(1);
    $this->setSourceFile("vorlage.pdf");
    // import page 1
    $tplIdx = $this->importPage(1);
    // use the imported page and place it at point 10,10 with a width of 100 mm
    $this->useTemplate($tplIdx, 0, 0, 210);

    $this->SetXY(150,10);
    $this->SetFont('Verdana','B',10);
    $this->Write(5, "Piratenpartei ");
    $this->SetFont('Verdana','',10);
    $this->Write(5, "Göppingen");
    $this->Ln();
    $this->Ln();
    $this->SetX(150);
    $this->MultiCell(0,5,$_SESSION['anschrift']);
    $this->Ln();
    $this->Ln();
    $this->Ln();

    if (($_SESSION['ansprechpartner1'] != "") || ($_SESSION['ansprechpartner2'] != "")) {
        $this->SetX(150);
        $this->SetFont('Verdana','B',8);
        $this->Write(5, "Ansprechpartner");
        $this->Ln();
        $this->Ln();
        $this->SetFont('Verdana','',8);
        
        if (($_SESSION['ansprechpartner1'] != "")) {
            $this->SetX(150);
            $this->Write(5, "Allgemeine Anfragen:");
            $this->Ln();
            $this->Ln();
            $this->SetX(150);
            $this->MultiCell(0,4,$_SESSION['ansprechpartner1']);
            $this->Ln();
        }
        if (($_SESSION['ansprechpartner2'] != "")) {
            $this->SetX(150);
            $this->Write(5, "Fragen zu dieser Pressmitteilung:");
            $this->Ln();
            $this->Ln();
            $this->SetX(150);
            $this->MultiCell(0,4,$_SESSION['ansprechpartner2']);
            $this->Ln();
        }
        
        $this->Ln();
        $this->Ln();
    }

    if (($_SESSION['treffen'] != "")) {
        $this->SetX(150);
        $this->SetFont('Verdana','B',8);
        $this->Write(5, "Treffen");
        $this->Ln();
        $this->Ln();
        $this->SetFont('Verdana','',8);
        $this->SetX(150);
        $this->MultiCell(0,4,$_SESSION['treffen']);
        $this->Ln();
        $this->Ln();
        $this->Ln();
    }
    $this->SetRightMargin(70);
    $this->SetXY(10,10);
}

function Footer()
{
$this->SetXY(10,284);
$this->SetFont('Verdana','',8);
$this->Write(5,"Seite ".$this->PageNo()." von {nb}");
}
}

// Instanciation of inherited class
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetMargins(10,10,10, 10);

$pdf->AddPage();
$pdf->SetTopMargin(35);
$pdf->SetRightMargin(70);
$pdf->SetFont('Verdana','B',14);
$pdf->Write(6, "Piratenpartei ");
$pdf->SetFont('Verdana','',14);
$pdf->Write(6, "Göppingen");
$pdf->Ln();
$pdf->SetFont('Verdana','',12);
$pdf->Write(6, "Pressemitteilung");
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Verdana','',10);
$pdf->Cell(150,5, $_SESSION['datum'],0,1);
$pdf->SetFont('Verdana','B',10);
$pdf->Write(5, $_SESSION['titel']);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Verdana','',10);
//$text = file_get_contents('text.html');
$pdf->WriteHTML($_SESSION['text']);
$pdf->Ln();
$pdf->AliasNbPages();
$pdf->Output("out/".session_id()."/PM-Piraten.pdf", "F");
?>
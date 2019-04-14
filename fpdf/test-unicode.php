<?php
require('chinese-unicode.php');

$pdf = new PDF_Unicode();
$pdf->AddUniCNShwFont('Uni');

//initialize document
$pdf->AliasNbPages();

$pdf->SetHeaderData('', '', 'Test', 'Test page string');
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(5);
$pdf->setPrintFooter(true);
$pdf->setPrintHeader(true);
$pdf->setHeaderFont(['Uni', 'BI', 12]);
$pdf->setFooterFont(['Uni', '', 8]);

$pdf->AddPage();

$pdf->Ln(10);
$pdf->SetFont('Uni', '', 8);

$htmlcontent = '<table border="0"><tr><td width="150">&nbsp;</td>
<td width="400"><a href="123123">學生 123123 </a>123132</td></tr></table><br><br><br><br><br><br><br><br>
<table border="1"><tr><td width="500">123123123123</td></tr></table>';
$pdf->writeHTML($htmlcontent, true, 0);
$pdf->Output();

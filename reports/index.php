<?php
/* This code will generate PDF file from the HTML file.
 You can also create a PDF file by providing the URL,get content by Curl or file_get_contents function and pass the content to
 WriteHTML function as used in below code.
 Hope this all will help,for more information/help mail to 
 
 scriptarticle(at)gmail(dot)com
 http://www.scriptarticle.com
*/
/*
require('html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("scriptarticle-sample.html","r");
$strContent = fread($fp, filesize("scriptarticle-sample.html"));
fclose($fp);
$pdf->WriteHTML($strContent);
$pdf->Output("sample.pdf");
echo "PDF file is generated successfully!";*/


require("../html2pdf/html2fpdf.php"); 
$htmlFile = "http://localhost/election/reports/form-12.php?personcd=TVRnd01UQXdNREF4&type=pb"; 
$buffer = file_get_contents($htmlFile); 

$pdf = new HTML2FPDF('P', 'mm', 'Legal'); 
$pdf->AddPage(); 
$pdf->WriteHTML($buffer); 
$pdf->Output('my.pdf', 'F');

?>
<script>window.open('my.pdf');</script>
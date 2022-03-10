<?php
require 'vendor/autoload.php';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('del.docx');
// Variables on different parts of document
$templateProcessor->setValue('weekday', date('l')); // On section/content
$templateProcessor->setValue('time', date('H:i')); // On footer
$templateProcessor->setValue('serverName', realpath(__DIR__)); // On header
// Simple table
$templateProcessor->cloneRow('rowValue', 10);
$templateProcessor->setValue('rowValue#1', 'Sun');
$templateProcessor->setValue('rowValue#2', 'Mercury');
$templateProcessor->setValue('rowValue#3', 'Venus');
$templateProcessor->setValue('rowValue#4', 'Earth');
$templateProcessor->setValue('rowValue#5', 'Mars');
$templateProcessor->setValue('rowValue#6', 'Jupiter');
$templateProcessor->setValue('rowValue#7', 'Saturn');
$templateProcessor->setValue('rowValue#8', 'Uranus');
$templateProcessor->setValue('rowValue#9', 'Neptun');
$templateProcessor->setValue('rowValue#10', 'Pluto');
$templateProcessor->setValue('rowNumber#1', '1');
$templateProcessor->setValue('rowNumber#2', '2');
$templateProcessor->setValue('rowNumber#3', '3');
$templateProcessor->setValue('rowNumber#4', '4');
$templateProcessor->setValue('rowNumber#5', '5');
$templateProcessor->setValue('rowNumber#6', '6');
$templateProcessor->setValue('rowNumber#7', '7');
$templateProcessor->setValue('rowNumber#8', '8');
$templateProcessor->setValue('rowNumber#9', '9');
$templateProcessor->setValue('rowNumber#10', '10');

$templateProcessor->cloneRow('rowValue2', 5);
$templateProcessor->setValue('rowValue2#1', '2Sun');
$templateProcessor->setValue('rowValue2#2', '2Mercury');
$templateProcessor->setValue('rowValue2#3', '2Venus');
$templateProcessor->setValue('rowValue2#4', '2Earth');
$templateProcessor->setValue('rowValue2#5', '2Mars');
$templateProcessor->setValue('rowNumber2#1', '11');
$templateProcessor->setValue('rowNumber2#2', '22');
$templateProcessor->setValue('rowNumber2#3', '33');
$templateProcessor->setValue('rowNumber2#4', '44');
$templateProcessor->setValue('rowNumber2#5', '55');

// Table with a spanned cell
$templateProcessor->cloneRow('userId', 3);
$templateProcessor->setValue('userId#1', '1');
$templateProcessor->setValue('userFirstName#1', 'James');
$templateProcessor->setValue('userName#1', 'Taylor');
$templateProcessor->setValue('userPhone#1', '+1 428 889 773');
$templateProcessor->setValue('userId#2', '2');
$templateProcessor->setValue('userFirstName#2', 'Robert');
$templateProcessor->setValue('userName#2', 'Bell');
$templateProcessor->setValue('userPhone#2', '+1 428 889 774');
$templateProcessor->setValue('userId#3', '3');
$templateProcessor->setValue('userFirstName#3', 'Michael');
$templateProcessor->setValue('userName#3', 'Ray');
$templateProcessor->setValue('userPhone#3', '+1 428 889 775');

header('Content-Type: application/vnd.ms-word');
header("Content-Disposition: attachment;filename=新檔名.docx");
header('Cache-Control: max-age=0');
$templateProcessor->saveAs('php://output');

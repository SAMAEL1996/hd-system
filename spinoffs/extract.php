<?php

namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

$pdfText = "";
$submitapp = filter_input(INPUT_POST, "submitapp", FILTER_SANITIZE_STRING);
if (isset($submitapp)) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_STRING);
    $letter = filter_input(INPUT_POST, "letter", FILTER_SANITIZE_STRING);
    // Display text content 
    if (!empty($_FILES["pdf_file"]["name"])) {
        // File upload path 
        $fileName = basename($_FILES["pdf_file"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        
        // Source PDF file to extract text 
            $file = $_FILES["pdf_file"]["tmp_name"];

        // Allow certain file formats 
        $allowTypes = array('pdf');
        if (in_array($fileType, $allowTypes)) {
            // Include autoloader file 
            include 'vendor/autoload.php';

            // Initialize and load PDF Parser library 
            $parser = new \Smalot\PdfParser\Parser();

            // Source PDF file to extract text 
            $file = $_FILES["pdf_file"]["tmp_name"];

            // Parse pdf file using Parser library 
            $pdf = $parser->parseFile($file);

            // Extract text from PDF 
            $text = $pdf->getText();

            
            
            
            $string = "Birthday:";
            // get the file contents, assuming the file to be readable (and exist)
            $contents = $text;
            // escape special characters in the query
            $pattern = preg_quote($string, '/');
            // finalise the regular expression, matching the whole line
            $pattern = "/^.*$pattern.*\$/m";
            // search, and store all matching occurences in $matches
            if (preg_match_all($pattern, $text, $matches)) {
                $tbtrim = implode("\n", $matches[0]);
                $trims = trim($tbtrim, $string);
                $trima = ltrim($trims);
                $trimb = rtrim($trima, "<br />");
                $trimc = rtrim($trimb);
                $trimd = trim($trimc, "");
                $birthday = $trimd;
                $pdfText = str_ireplace($trimd, "BIRTHDAY", $text);
            
            
            // Add line break 
            $pdfText1 = nl2br($pdfText);
            } else {
                //
            }
            
            
            

            //SEARCH STRING
            /* include('PdfTotext/PdfToText.phpclass');
              $searchpdf = new PdfToText($file);
              $string = "Birthday:";
              $data = $searchpdf->Text;
              if(strpos($data,$string) !== false){
              echo $string; */
              } 
        } else {
            $statusMsg = '<p>Sorry, only PDF file is allowed to upload.</p>';
        } 
    } else {
        //$statusMsg = '<p>Please select a PDF file to extract text.</p>';
    }


$string = "Birthday:";
// get the file contents, assuming the file to be readable (and exist)
$contents = $pdfText;
// escape special characters in the query
$pattern = preg_quote($string, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
if (preg_match_all($pattern, $pdfText, $matches)) {
    $tbtrim = implode("\n", $matches[0]);
    $trims = trim($tbtrim, $string);
    $trima = ltrim($trims);
    $trimb = rtrim($trima, "<br />");
    $trimc = rtrim($trimb);
    $trimd = trim($trimc, "");
    $birthday = $trimd;
} else {
    //
}

$string2 = "Address:";
// get the file contents, assuming the file to be readable (and exist)
// escape special characters in the query
$pattern2 = preg_quote($string2, '/');
// finalise the regular expression, matching the whole line
$pattern2 = "/^.*$pattern2.*\$/m";
// search, and store all matching occurences in $matches
if (preg_match_all($pattern2, $pdfText, $matches2)) {
    $tbtrim = implode("\n", $matches2[0]);
    $trims = trim($tbtrim, $string2);
    $trima = ltrim($trims);
    $trimb = rtrim($trima, "<br />");
    $trimc = rtrim($trimb);
    $trimd = trim($trimc, "");
    $address = $trimd;
} else {
    //
} 
<?php

namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

$pdfText = "";
$cvinsert = filter_input(INPUT_POST, "cvinsert", FILTER_SANITIZE_STRING);
if (isset($cvinsert)) {
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

            // Add line break 
            $pdfText1 = nl2br($text);

            //SEARCH STRING
            /* include('PdfTotext/PdfToText.phpclass');
              $searchpdf = new PdfToText($file);
              $string = "Birthday:";
              $data = $searchpdf->Text;
              if(strpos($data,$string) !== false){
              echo $string; */
            
            $string = "Birthday";
            // get the file contents, assuming the file to be readable (and exist)
            $contents = $pdfText1;
            // escape special characters in the query
            $pattern = preg_quote($string, '/');
            // finalise the regular expression, matching the whole line
            $pattern = "/^.*$pattern.*\$/m";
            // search, and store all matching occurences in $matches
            if (preg_match_all($pattern, $pdfText1, $matches)) {
                $tbtrim = implode("\n", $matches[0]);
                $trims = trim($tbtrim, $string);
                $trima = ltrim($trims);
                $trimb = rtrim($trima, "<br />");
                $trimc = rtrim($trimb);
                $trimd = trim($trimc, ":");
                $birthday = $trimd;
                $insertbday = "'" . $birthday . "'";
                $pdfText = str_ireplace($trimd, '<button type="submit" onclick="myFunction('.$insertbday.')">'.$birthday.'</button>', $pdfText1);
            
            
            // Add line break 
            $pdfText1 = nl2br($pdfText);
            } else {
                $pdfText = nl2br($text);
            }
              } 
        } else {
            
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
?>
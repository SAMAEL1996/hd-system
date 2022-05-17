<?php

namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Vision\V1\AnnotateFileResponse;
use Google\Cloud\Vision\V1\AsyncAnnotateFileRequest;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\GcsDestination;
use Google\Cloud\Vision\V1\GcsSource;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\InputConfig;
use Google\Cloud\Vision\V1\OutputConfig;

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

        $path = 'gs://test-217.pdf';


        $output = './public/pdf/';

        function detect_pdf_gcs($file, $output) {
            # select ocr feature
            $feature = (new Feature())
                    ->setType(Type::DOCUMENT_TEXT_DETECTION);

            # set $path (file to OCR) as source
            $gcsSource = (new GcsSource())
                    ->setUri($file);
            # supported mime_types are: 'application/pdf' and 'image/tiff'
            $mimeType = 'application/pdf';
            $inputConfig = (new InputConfig())
                    ->setGcsSource($gcsSource)
                    ->setMimeType($mimeType);

            # set $output as destination
            $gcsDestination = (new GcsDestination())
                    ->setUri($output);
            # how many pages should be grouped into each json output file.
            $batchSize = 2;
            $outputConfig = (new OutputConfig())
                    ->setGcsDestination($gcsDestination)
                    ->setBatchSize($batchSize);

            # prepare request using configs set above
            $request = (new AsyncAnnotateFileRequest())
                    ->setFeatures([$feature])
                    ->setInputConfig($inputConfig)
                    ->setOutputConfig($outputConfig);
            $requests = [$request];

            # make request
            $imageAnnotator = new ImageAnnotatorClient();
            $operation = $imageAnnotator->asyncBatchAnnotateFiles($requests);
            print('Waiting for operation to finish.' . PHP_EOL);
            $operation->pollUntilComplete();

            # once the request has completed and the output has been
            # written to GCS, we can list all the output files.
            preg_match('/^gs:\/\/([a-zA-Z0-9\._\-]+)\/?(\S+)?$/', $output, $match);
            $bucketName = $match[1];
            $prefix = isset($match[2]) ? $match[2] : '';

            $storage = new StorageClient();
            $bucket = $storage->bucket($bucketName);
            $options = ['prefix' => $prefix];
            $objects = $bucket->objects($options);

            # save first object for sample below
            $objects->next();
            $firstObject = $objects->current();

            # list objects with the given prefix.
            print('Output files:' . PHP_EOL);
            foreach ($objects as $object) {
                print($object->name() . PHP_EOL);
            }

            # process the first output file from GCS.
            # since we specified batch_size=2, the first response contains
            # the first two pages of the input file.
            $jsonString = $firstObject->downloadAsString();
            $firstBatch = new AnnotateFileResponse();
            $firstBatch->mergeFromJsonString($jsonString);

            # get annotation and print text
            foreach ($firstBatch->getResponses() as $response) {
                $annotation = $response->getFullTextAnnotation();
                print($annotation->getText());
            }

            $imageAnnotator->close();
        }

    }
    /*
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
      } */
}   
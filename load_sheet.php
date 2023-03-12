<?php
include "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json; charset=utf-8');
// Check if file was uploaded without errors
$result='';
// Check if file was uploaded without errors
if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0){
  // Get file name, size and type
  $fileName = $_FILES["fileToUpload"]["name"];
  $fileSize = $_FILES["fileToUpload"]["size"];
  $fileType = $_FILES["fileToUpload"]["type"];

  // Specify the allowed file types and size limit (1MB)
  $allowedTypes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

  $maxSize = 1024 * 1024;

  // Validate file type and size
  if(in_array($fileType, $allowedTypes) && $fileSize <= $maxSize){
    // Choose a destination folder for the uploaded file
      $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
      $spreadsheet = IOFactory::load($inputFileName);
      $allSheetName = $spreadsheet->getSheetNames();
      //$spreadsheet=$spreadsheet->getSheet(1);
      //$spreadsheet=$spreadsheet->getSheetByName('Sheet1');
      //print_r($all);
      //die;
      //$sheetData = $spreadsheet->toArray(null, true, true, true);
      //array_shift($sheetData);
      $arrJson=[];
      foreach($allSheetName as $key=>$item){
        $arrJson[]=[
          'id'=>$key,
          'name'=>$item
        ];
      }
      $result=['info'=>1,"data"=>$arrJson,"message"=>"upload success"];
    
  } else{
    $result=['info'=>0,"message"=>"Invalid file type or size"];
  }
} else{
  $result=['info'=>0,"message"=>"No file uploaded or error occurred"];
}

echo json_encode($result,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
?>
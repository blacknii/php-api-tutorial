<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Access-Control-Allow-Headers');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "POST"){

  $inputData = json_decode(file_get_contents("php://input"), true);
  if(empty($inputData)){
    $storeChannel = storeChannel($_POST);
  } else {
    $storeChannel = storeChannel($inputData);
  }

  echo $storeChannel;

} else{
  $data = [
    'status' => 405,
    'message' => $requestMethod. ' Method Not Allowed'
  ];
  header("HTTP/1.0 405 Method Not Allowed");
  echo json_encode($data);
}
?>

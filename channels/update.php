<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Access-Control-Allow-Headers');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit;
}

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "PUT"){

  $inputData = json_decode(file_get_contents("php://input"), true);
  $updateChannel = updateChannel($inputData, $_GET);

  echo $updateChannel;

} else{
  $data = [
    'status' => 405,
    'message' => $requestMethod. ' Method Not Allowed'
  ];
  header("HTTP/1.0 405 Method Not Allowed");
  echo json_encode($data);
}


?>

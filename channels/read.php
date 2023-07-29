<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Access-Control-Allow-Headers');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "GET"){

  if(isset($_GET['id'])){

    $channel = getChannel($_GET);
    echo $channel;
  } else {

    $channelList = getChannelList();
    echo $channelList;
  }
}else{
  $data = [
    'status' => 405,
    'message' => $requestMethod. ' Method Not Allowed'
  ];
  header("HTTP/1.0 405 Method Not Allowed");
  echo json_encode($data);
}

?>

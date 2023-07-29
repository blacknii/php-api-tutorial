<?php

require '../inc/dbcon.php';

function error422($message){
  $data = [
    'status' => 422,
    'message' => $message,
  ];
  header("HTTP/1.0 422 Unprocessable Entity");
  echo json_encode($data);
  exit();
}

function storeChannel($channelInput) {
  global $conn;
  $name = mysqli_real_escape_string($conn, $channelInput['name']);
  $amount = mysqli_real_escape_string($conn, $channelInput['amount']);

  if(empty(trim($name))){
    return error422('enter the channel name');
  } elseif(empty(trim($amount))) {
    return error422('enter the amount');
  } else {
    $query = "INSERT INTO channels (name,amount) VALUES ('$name','$amount')";
    $result = mysqli_query($conn, $query);

    if($result){
      $data = [
        'status' => 201,
        'message' => 'Channel Created Successfully'
      ];
      header("HTTP/1.0 201 Created");
      return json_encode($data);
    } else {
      $data = [
        'status' => 500,
        'message' => 'Internal Server Error'
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
    }
  }
}

function getChannelList(){
  global $conn;

  $query = "SELECT * FROM channels";
  $query_run = mysqli_query($conn, $query);

  if($query_run){

    if(mysqli_num_rows($query_run) > 0){

      $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

      $data = [
        'status' => 200,
        'message' => 'Channel List Fetched Successfully',
        'data' => $res,
      ];
      header("HTTP/1.0 200 OK");
      return json_encode($data);
    } else {
      $data = [
        'status' => 404,
        'message' => 'No Channel Found'
      ];
      header("HTTP/1.0 404 Not Found");
      return json_encode($data);
    }

  }else {
    $data = [
      'status' => 500,
      'message' => 'Internal Server Error'
    ];
    header("HTTP/1.0 500 Internal Server Error");
    return json_encode($data);
  }

}

function getChannel($channelParams){

  global $conn;

  if($channelParams['id'] == null){
    return error422('enter the channel id');
  }

  $channelId = mysqli_real_escape_string($conn, $channelParams['id']);

  $query = "SELECT * FROM channels WHERE id='$channelId' LIMIT 1" ;
  $result = mysqli_query($conn, $query);

  if($result){

    if(mysqli_num_rows($result) == 1) {
      $res = mysqli_fetch_assoc($result);

      $data = [
        'status' => 200,
        'message' => 'Channel Fetched Successfully',
        'data' => $res
      ];
      header("HTTP/1.0 200 OK");
      return json_encode($data);
    }
     else {
      $data = [
        'status' => 404,
        'message' => 'No Channel Found'
      ];
      header("HTTP/1.0 404 Not Found");
      return json_encode($data);
    }

  } else {
    $data = [
      'status' => 500,
      'message' => 'Internal Server Error'
    ];
    header("HTTP/1.0 500 Internal Server Error");
    return json_encode($data);
  }
}

function updateChannel($channelInput, $channelParams) {
  global $conn;

  if(!isset($channelParams['id'])){
    return error422('channel id not found in URL');
  } elseif  ($channelParams['id'] == null){
    return error422('Enter the channel id');
  }

  $channelId = mysqli_real_escape_string($conn, $channelParams['id']);

  $name = mysqli_real_escape_string($conn, $channelInput['name']);
  $amount = mysqli_real_escape_string($conn, $channelInput['amount']);

  if(empty(trim($name))){
    return error422('enter the channel name');
  } elseif(empty(trim($amount))) {
    return error422('enter the amount');
  } else {
    $query = "UPDATE channels SET name='$name', amount='$amount' WHERE id='$channelId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
      $data = [
        'status' => 200,
        'message' => 'Channel Updated Successfully'
      ];
      header("HTTP/1.0 200 OK");
      return json_encode($data);
    } else {
      $data = [
        'status' => 500,
        'message' => 'Internal Server Error'
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
    }
  }
}

function deleteChannel($channelParams) {
  global $conn;

  if(!isset($channelParams['id'])){
    return error422('channel id not found in URL');
  } elseif  ($channelParams['id'] == null){
    return error422('Enter the channel id');
  }

  $channelId = mysqli_real_escape_string($conn, $channelParams['id']);

  $query = "DELETE FROM channels WHERE id='$channelId' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if($result){
    $data = [
      'status' => 200,
      'message' => 'Channel Deleted Successfully'
    ];
    header("HTTP/1.0 200 OK");
    return json_encode($data);
  } else {
    $data = [
      'status' => 500,
      'message' => 'Internal Server Error'
    ];
    header("HTTP/1.0 500 Internal Server Error");
    return json_encode($data);
  }

}

?>

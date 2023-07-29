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

function storeCustomer($customerInput) {
  global $conn;
  $name = mysqli_real_escape_string($conn, $customerInput['name']);
  $amount = mysqli_real_escape_string($conn, $customerInput['amount']);

  if(empty(trim($name))){

    return error422('enter your name');
  } elseif(empty(trim($amount))) {

    return error422('enter your amount');
  } else {

    $query = "INSERT INTO channels (name,amount) VALUES ('$name','$amount')";
    $result = mysqli_query($conn, $query);

    if($result){
      $data = [
        'status' => 201,
        'message' => 'Customer Created Successfully'
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

function getCustomerList(){
  global $conn;

  $query = "SELECT * FROM channels";
  $query_run = mysqli_query($conn, $query);

  if($query_run){

    if(mysqli_num_rows($query_run) > 0){

      $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

      $data = [
        'status' => 200,
        'message' => 'Customer List Fetched Successfully',
        'data' => $res,
      ];
      header("HTTP/1.0 200 OK");
      return json_encode($data);
    } else {
      $data = [
        'status' => 404,
        'message' => 'No Customer Found'
      ];
      header("HTTP/1.0 404 No Customer Found");
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

function getCustomer($customerParams){

  global $conn;

  if($customerParams['id'] == null){

    return error422('enter your customer id');
  }

  $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

  $query = "SELECT * FROM channels WHERE id='$customerId' LIMIT 1" ;
  $result = mysqli_query($conn, $query);

  if($result){

    if(mysqli_num_rows($result) == 1) {
      $res = mysqli_fetch_assoc($result);

      $data = [
        'status' => 200,
        'message' => 'Customer Fetched Successfully',
        'data' => $res
      ];
      header("HTTP/1.0 200 OK");
      return json_encode($data);
    }
     else {
      $data = [
        'status' => 404,
        'message' => 'No Customer Found'
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

function updateCustomer($customerInput, $customerParams) {
  global $conn;

  if(!isset($customerParams['id'])){

    return error422('customer id not found in URL');
  } elseif  ($customerParams['id'] == null){

    return error422('Enter the customer id');
  }

  $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

  $name = mysqli_real_escape_string($conn, $customerInput['name']);
  $amount = mysqli_real_escape_string($conn, $customerInput['amount']);

  if(empty(trim($name))){


    return error422('enter your name');
  } elseif(empty(trim($amount))) {

    return error422('enter your amount');
  } else {
    $query = "UPDATE channels SET name='$name', amount='$amount' WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
      $data = [
        'status' => 200,
        'message' => 'Customer Updated Successfully'
      ];
      header("HTTP/1.0 200 Success");
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

function deleteCustomer($customerParams){

  global $conn;

  if(!isset($customerParams['id'])){

    return error422('customer id not found in URL');
  } elseif  ($customerParams['id'] == null){

    return error422('Enter the customer id');
  }

  $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

  $query = "DELETE FROM channels WHERE id='$customerId' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if($result){
    $data = [
      'status' => 200,
      'message' => 'Customer Deleted Successfully'
    ];
    header("HTTP/1.0 200 OK");
    return json_encode($data);
  } else {
    $data = [
      'status' => 404,
      'message' => 'Customer Not Found'
    ];
    header("HTTP/1.0 404 Not Found");
    return json_encode($data);
  }

}


?>

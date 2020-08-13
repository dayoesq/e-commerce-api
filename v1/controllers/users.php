<?php 

/*
|--------------------------------------------------------------------------
| This route accepts POST, GET, PATCH, DELETE methods 
|--------------------------------------------------------------------------
|
| Create user controller  
| 
| 
|
*/

declare(strict_types = 1);


require_once "../config/Database.php";
require_once "../models/User.php";
require_once "../models/Response.php";
require_once "../models/UserException.php";

try {
  $writeDB = Database::writeDB();
} 
catch(PDOException $e) {
  error_log("Database connection failed - ". $e, 0);
  $res = new Response();
  $res->setHttpStatusCode(500);
  $res->setMessage("Could not connect to database");
  $res->setSuccess(false);
  $res->send();
  exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  $res = new Response();
  $res->setHttpStatusCode(405);
  $res->setMessage("Request method not allowed");
  $res->setSuccess(false);
  $res->send();
  exit;
}

if($_SERVER["CONTENT_TYPE"] !== "application/json") {
  $res = new Response();
  $res->setHttpStatusCode(400);
  $res->setMessage("Content type header not JSON");
  $res->setSuccess(false);
  $res->send();
  exit;
}

$rawPostData = file_get_contents("http://input");

if(!$jsonData = json_decode($rawPostData)) {
  $res = new Response();
  $res->setHttpStatusCode(400);
  $res->setMessage("Content body not valid JSON");
  $res->setSuccess(false);
  $res->send();
  exit;
}

if(!isset($jsonData->firstname) || !isset($jsonData->lastname)
 || !isset($jsonData->email) || !isset($jsonData->username) 
 || !isset($jsonData->password) || !isset($jsonData->phone)) {
  $res = new Response();
  $res->setHttpStatusCode(400);
  (!isset($jsonData->firstname) ? $res->setMessage("The firstname is required") : false);
  (!isset($jsonData->lastname) ? $res->setMessage("The lastname is required") : false);
  (!isset($jsonData->username) ? $res->setMessage("The username is required") : false);
  (!isset($jsonData->email) ? $res->setMessage("The email is required") : false);
  (!isset($jsonData->phone) ? $res->setMessage("The phone is required") : false);
  $res->setSuccess(false);
  $res->send();
  exit;
 }

 $firstname = $jsonData->firstname;
 $lastname = $jsonData->lastname;
 $username = $jsonData->username;
 $email = $jsonData->email;
 $phone = $jsonData->phone;
 $password = $jsonData->password;

//  I should check for some other validation conditions like regex... may be later

try {
  $query = $writeDB->prepare("SELECT id FROM users WHERE username = :username");
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->execute();

  $rowCount = $query->rowCount();
  if($rowCount > 0) {
    $res = new Response();
    $res->setHttpStatusCode(409);
    $res->setMessage("The user already exists");
    $res->setSuccess(false);
    $res->send();
    exit;
  }

  $password_hash = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));

  $query = $writeDB->prepare("INSERT INTO users (firstname, lastname, username, email, password, phone) 
  $query .= VALUES (:firstname, :lastname, :username, :email, :password, :phone)");
  $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
  $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->bindParam(':phone', $phone, PDO::PARAM_STR);

  $query->execute();

  $lastId = lastInsertId();

  $query = $writeDB->prepare("SELECT id, firstname, lastname, username, email, phone FROM users WHERE id = :id");
  $query->bindParam(':id', $lastId, PDO::PARAM_INT);
  $query->execute();

  $row = $query->fetch(PDO::FETCH_ASSOC);

  $user = new User();

  $user->setId($row['id']);
  $user->setFirstname($row['firstname']);
  $user->setLastname($row['lastname']);
  $user->setUsername($row['username']);
  $user->setEmail($row['email']);
  $user->setPhone($row['phone']);


  $returnData = array();
  $returnData['id'] = $row['id'];
  $returnData['firstname'] = $row['firstname'];
  $returnData['lastname'] = $row['lastname'];
  $returnData['email'] = $row['email'];
  $returnData['phone'] = $row['phone'];

  $res = new Response();
  $res->setHttpStatusCode(201);
  $res->setMessage("User created");
  $res->setSuccess(true);
  $res->setData($returnData);
  $res->send();
  exit;

} catch(PDOException $e) {
  error_log("Database query error " . $e, 0);
  $res = new Response();
  $res->setHttpStatusCode(500);
  $res->setMessage("Database query error");
  $res->setSuccess(false);
  $res->send();
  exit;
}




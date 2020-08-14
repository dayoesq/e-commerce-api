<?php 

/*
|--------------------------------------------------------------------------
| This route accepts POST, GET, PATCH, DELETE methods 
|--------------------------------------------------------------------------
|
| Display  all the users to the Super Manager. 
| 
| 
|
*/

declare(strict_types = 1);


require_once '../config/Database.php';
require_once '../models/User.php';
require_once '../models/Response.php';
require_once '../models/UserException.php';

try {
  $readDB = Database::readDB();
} catch(PDOException $e) {
  error_log('Connection failed - ' . $e, 0);
  $response = new Response();
  $response->setHttpStatusCode(500);
  $response->setMessage('Connection failed');
  $response->setSuccess(false);
  $response->send();
  exit;
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(array_key_exists('id', $_GET)) {
    if(intval($_GET['id'])) {
      $id = $_GET['id'];
      try {
        $query = $readDB->prepare("SELECT id, firstname, lastname, username, email, phone, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') as created_at FROM users WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $rowCount = $query->rowCount();
        if($rowCount !== 1) {
          $response = new Response();
          $response->setHttpStatusCode(404);
          $response->setMessage('Not found');
          $response->setSuccess(false);
          $response->send();
          exit;
        }
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
          (object)$user = new User();
          $user->setId($row['id']);
          $user->setFirstname($row['firstname']);
          $user->setLastname($row['lastname']);
          $user->setUsername($row['username']);
          $user->setEmail($row['email']);
          $user->setPhone($row['phone']);
          $user->setDate($row['created_at']);
        }
        (array)$fetchedData = $user->returnUserAsArray();
        (array)$data = [];
        $data['rows_returned'] = $rowCount; 
        $data['users'] = $fetchedData;
        $response = new Response();
        $response->setHttpStatusCode(200);
        $response->setSuccess(true);
        $response->setMessage('Successful');
        $response->setData($data);
        $response->send();
        exit;
      } 
      catch(PDOException $e) {
        error_log('Connection failed - ' . $e->getMessage(), 0);
        (object)$response = new Response();
        $response->setHttpStatusCode(500);
        $response->setMessage('Connection failed' . $e->getMessage());
        $response->setSuccess(false);
        $response->send();
        exit;
      }
    }
    $response = new Response();
    $response->setHttpStatusCode(404);
    $response->setMessage('The ' . $_GET['id'] . ' must be an integer');
    $response->setSuccess(false);
    $response->send();
    exit;
  }
}
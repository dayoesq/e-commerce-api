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
require_once '../functions/helper.php';

try {
  $readDB = Database::readDB();
} catch(PDOException $e) {
  error_log('Connection failed - ' . $e, 0);
  sendResponse(500, false, 'Connection failed');
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(array_key_exists('id', $_GET)) {
    if(intval($_GET['id'])) {
      $id = $_GET['id'];
      try {
        $query = $readDB->prepare("SELECT id, firstname, lastname, 
        username, email, phone, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') as created_at, 
        DATE_FORMAT(updated_at, '%d-%m-%Y %H:%i') as updated_at
        FROM users WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $rowCount = $query->rowCount();
        if($rowCount !== 1) {
          sendResponse(404, false, 'Not found');
        }
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
          (object)$user = new User();
          $user->setId($row['id']);
          $user->setFirstname($row['firstname']);
          $user->setLastname($row['lastname']);
          $user->setUsername($row['username']);
          $user->setEmail($row['email']);
          $user->setPhone($row['phone']);
          $user->setCreatedAt($row['created_at']);
          $user->setUpdatedAt($row['updated_at']);
        }
        (array)$fetchedData = $user->toArray();
        // Get real data with values 
        $realData = array_filter($fetchedData, function($realValue) {
          return $realValue !== null;
        });
        $data = [];
        $data['rows_returned'] = $rowCount; 
        $data['users'] = $realData;
        sendResponse(200, true, 'Success', false, $data);
      } 
      catch(PDOException $e) {
        error_log('Connection failed - ' . $e->getMessage(), 0);
        sendResponse(500, false, 'Connection failed ' . $e->getMessage(), false);
      }
    }
    sendResponse(404, false, 'The ' . $_GET['id'] . ' must be an integer', false);
  }
}
<?php 

declare(strict_types = 1);

require_once '../models/Response.php';

function sendResponse(int $statusCode, bool $success = false, string $messages = null, bool $toCache = false, array $data = null) {
  $response = new Response();
  $response->setHttpStatusCode($statusCode);
  if($messages !== null) {
    $response->setMessage($messages);
  }
  $response->toCache($toCache);
  if($data !== null) {
    $response->setData($data);
  }
  $response->setSuccess($success);
  $response->send();
  exit;
}
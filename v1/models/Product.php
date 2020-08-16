<?php 

class Product extends Exception {
  private $id;
  private $name;
  private $description;
  private $brand;
  private $userId;
  private $productCategoryId;
  private $productImage;
  private $createdAt;
  private $updatedAt;

  public function __construct() 
  {

  }
  
}
<?php

declare(strict_types=1);

require_once '../config/Database.php';

class DbObject extends Database {

    private $db = null;
    
    protected function db()
    {
      return $this->db = new Database();
    }

    public static function all()
    {
      return static::findByQuery("SELECT * FROM " . static::$dbTable . " ");
    }
    
    public static function find($id) 
    {
      $resultArray = static::findByQuery("SELECT * FROM " . static::$dbTable . " WHERE id = $id LIMIT 1");
      return !empty($resultArray) ? array_shift($resultArray) : false;
    }
    
    public static function findByQuery($sql) {
      $result = $this->db()->query($sql);
      $theObjectArray = array();
      while($row = $this->db()->fetchAll($result)) {
        $theObjectArray[] = static::instantiation($row);
      }
      return $theObjectArray; 
    }
    
    private static function instantiation($record) {
      $callingClass = get_called_class();
      $object = new $callingClass;
      foreach($record as $attribute => $value) {
        if($object->hasAttribute($attribute)) {
          $object->$attribute = $value;
        }
      return $object;
    }
  }

  public function hasAttribute($attribute)
  {
    $objectProperties = get_object_vars($this);
    return array_key_exists($attribute, $objectProperties);
  }

  protected function properties()
  {
    $properties = [];
    foreach(static::$dbTableFields as $dbTable) {
      if(property_exists($this, $dbTable)) {
        $properties[$dbTable] = $this->$dbTable; 
      }
      return $properties;
    }
  }

  public function cleanData()
  {
    $cleanProperties = [];
    foreach($this->properties() as $key => $value) {
      $cleanProperties[$key] = $this->db->trim($value);
    }
    return $cleanProperties;
  }

  public function save()
  {
    return isset($this->id) ? $this->updade() : $this->create();
  }
  
  /**
   * Insert new fields into the database
   *
   * @return bool
   */
  public function create()
  {
    $properties = $this->cleanData();
    $sql = "INSERT INTO " . static::$dbTable . "(" . implode( ",", array_keys($properties)) . ")";
    $sql .= " VALUES ('" . implode( "','", array_values($properties)) . "')";
    if($this->db()->query($sql)) {
      $this->id = $this->db()->lastInsertId();
      return true;
    }
    return false;
  }

  public function update()
  {
    $properties = $this->cleanData();
    $propertyPairs = [];
    foreach($properties as $key => $value) {
      $propertyPairs[] = "$key = '$value'";
    }
    $sql = "UPDATE " . static::$dbTable . " SET ";
    $sql .= implode(", ", $propertyPairs);
    $sql .= " WHERE id = " . $this->db()->$this->id; 
    $this->db()->query($sql);
    return $this->db()->rowCount() === 1 ? true : false;
  }

  public function delete() 
  {
    $sql = "DELETE FROM " . static::$dbTable . " "; 
    $sql .= " WHERE id = " . $this->db()->$this->id; 
    $sql .= " LIMIT 1";
    $this->db()->query($sql);
    return $this->db()->rowCount() === 1 ? true : false;
  }

}


<?php 

declare(strict_types = 1);

require_once '../interfaces/Arrayable.php';
require_once 'ImageImageException.php';

class Image extends ImageException implements Arrayable{
  
  /**
   * id
   *
   * @var int
   */
  private $id;  
  /**
   * title
   *
   * @var string
   */
  private $title;  
  /**
   * filename
   *
   * @var string
   */
  private $filename;  
  /**
   * mimetype
   *
   * @var string
   */
  private $mimeType;  
  /**
   * userId
   *
   * @var int
   */
  private $userId;  
  /**
   * uploadFolderLocation
   *
   * @var mixed
   */
  private $uploadFolderLocation;  
  /**
   * createdAt
   *
   * @var string
   */
  private $createdAt;  
  /**
   * updatedAt
   *
   * @var string
   */
  private $updatedAt;
 
  /**
   * getId
   *
   * @return int
   */
  public function getId() 
  {
    return $this->id;
  }
  
  /**
   * getTitle
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }
  
  /**
   * getFilename
   *
   * @return string
   */
  public function getFilename()
  {
    return $this->filename;
  }
  
  /**
   * getFileExtension
   *
   * @return string
   */
  public function getFileExtension()
  {
    (string)$filenameParts = explode('.', $this->filename);
    $lastArrayElements = count($filenameParts) - 1;
    $fileExtension = $filenameParts[$lastArrayElements];
    return $fileExtension;
  }
  
  /**
   * getMimeType
   *
   * @return string
   */
  public function getMimeType() 
  {
    return $this->mimeType;
  }
  
  /**
   * getUserId
   *
   * @return int
   */
  public function getUserId()
  {
    return $this->userId;
  }
  
  /**
   * getUploadFolderLocation
   *
   * @return void
   */
  public function getUploadFolderLocation()
  {
    return $this->uploadFolderLocation;
  }
  
  /**
   * getImageUrl
   *
   * @return string
   */
  public function getImageUrl()
  {
    (string)$httpsOrHttp = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
    (string)$host = $_SERVER['HTTP_HOST'];
    (string)$url = "/v1/users/".$this->getUserId()."/images/".$this->getId();
    return $httpsOrHttp."://".$host.$url;
  }
  
  /**
   * setId
   *
   * @param  int $id
   * @return int
   */
  public function setId($id) 
  {
    if(($id !== null) && (!is_numeric($id) || $id <= 0 || $id > 92233720368547755807 || $this->id !== null)) {
      throw new ImageException("Image id error");
    }
    return $this->id = $id;
  }
  
  /**
   * setTitle
   *
   * @param  string $title
   * @return string
   */
  public function setTitle(string $title) 
  { 
    (int)$min = 1; (int)$max = 30;
    if(strlen($title) < $min) {
      throw new ImageException('Image title is required');
    } elseif(strlen($title) > $max) {
      throw new ImageException('Image title is too long');
    }
    return $this->title = $title;
  }
  
  /**
   * setFilename
   *
   * @param  string $filename
   * @return string
   */
  public function setFilename(string $filename)
  {
    (int)$min = 1; (int)$max = 30;
    (string)$pattern = '/^([a-zA-Z0-9]+)(.png|.jpeg|.gif.|jpg)$/';
    if(strlen($filename) < $min) {
      throw new ImageException('The filename is required');
    } elseif(strlen($filename) > $max) {
      throw new ImageException('The filename is too long');
    } elseif(!preg_match($pattern, $filename)) {
      throw new ImageException('Invalid file format');
    }
    return $this->filename = $filename;
  }
  
  /**
   * setMimeType
   *
   * @param  string $mimeType
   * @return string
   */
  public function setMimeType(string $mimeType)
  {
    (int)$min = 1; (int)$max = 255;
    if(strlen($mimeType) < $min) {
      throw new ImageException('The mimetype is required');
    } elseif($mimeType > $max) {
      throw new ImageException('The mimetype is too long');
    } 
    return $this->mimeType = $mimeType;
  }
  
  /**
   * setUserId
   *
   * @param  int $userId
   * @return int
   */
  public function setUserId(int $userId) 
  {
    if(($userId !== null) && (!is_numeric($userId) || $userId <= 0 || $userId > 92233720368547755807 || $this->userId !== null)) {
      throw new ImageException("User id error");
    }
    return $this->userId = $userId;
  }
  
  /**
   * toArray
   *
   * @return array
   */
  public function toArray()
  {
    (array)$images = [];
    $images['id'] = $this->getId();
    $images['title'] = $this->getTitle();
    $images['filename'] = $this->getFilename();
    $images['mimetype'] = $this->getMimeType();
    $images['userid'] = $this->getUserId();
    $images['imageurl'] = $this->getImageUrl();
    return $images;
  }

  

}
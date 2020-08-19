<?php

declare(strict_types = 1);

require_once '../interfaces/Arrayable.php';

class User extends Exception implements Arrayable
{    
    /**
     * id
     *
     * @var int
     */
    private $id;    
    /**
     * firstname
     *
     * @var string
     */
    private $firstname;    
    /**
     * lastname
     *
     * @var string
     */
    private $lastname;    
    /**
     * username
     *
     * @var string
     */
    private $username;    
    /**
     * email
     *
     * @var string
     */
    private $email;    
    /**
     * password
     *
     * @var string
     */
    private $password;    
    /**
     * active
     *
     * @var string
     */
    private $active;    
    /**
     * phone
     *
     * @var string
     */
    private $phone;

    /**
     * date
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
     * __construct
     *
     * @return void
     */
    public function __construct() 
    {
    
    }
    
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
     * getFirstname
     *
     * @return string
     */
    public function getFirstname() 
    {
        return $this->firstname;
    }
    
    /**
     * getLastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * getUsername
     *
     * @return string
     */
    public function getUsername() 
    {
        return $this->username;
    }
        
    /**
     * getEmail
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * getPassword
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * getStatus
     *
     * @return string
     */
    public function getStatus() 
    {
        return $this->active;
    }    
    /**
     * getPhone
     *
     * @return string
     */
    public function getPhone() 
    {
        return $this->phone;
    }
    
    /**
     * getData
     *
     * @return string
     */
    public function getCreatedAt() 
    {
        return $this->createdAt;
    }
    
    /**
     * getUpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * setId
     *
     * @param  int $id
     * @return int
     */
    public function setId(int $id) 
    {
        if(($id !== null) && (!is_numeric($id) || $id <= 0 || $id > 92233720368547755807 || $this->id !== null)) {
            throw new Exception("User ID Error");
        }
        return $this->id = $id;
    }
    
    /**
     * setFirstname
     *
     * @param  string $firstname
     * @return string
     */
    public function setFirstname(string $firstname) 
    {
        $min = 1; $max = 30;
        if(isset($firstname)) {
            if(is_string($firstname)) {
                if(strlen($firstname) < $min) {
                    throw new Exception("The firstname cannot be empty");
                } elseif(strlen($firstname) > $max) {
                    throw new Exception("The firstname is too long");
                } elseif(!preg_match('/^[a-zA-Z]+$/', $firstname)) {
                    throw new Exception("Invalid name format");
                }
            }
           return $this->firstname = trim(ucfirst(strtolower($firstname)));
        } 
        throw new Exception("The firstname is required");
    }
    
    /**
     * setLastname
     *
     * @param  string $lastname
     * @return string
     */
    public function setLastname(string $lastname) 
    {
        $min = 1; $max = 30; $pattern = '/^[a-zA-Z]+$/';
        if(!empty($lastname)) {
            if(is_string($lastname)) {
                if(strlen($lastname) < $min) {
                    throw new Exception("The lastname cannot be empty");
                } elseif(strlen($lastname) > $max) {
                    throw new Exception("The lastname is too long");
                } elseif(!preg_match($pattern, $lastname)) {
                    throw new Exception("Invalid name format");
                }
            }
            return $this->lastname = trim(ucfirst(strtolower($lastname)));
        }
        throw new Exception("The lastname is required");
    }
    
    /**
     * setUsername
     *
     * @param  string $username
     * @return string
     */
    public function setUsername(string $username) 
    {
        $pattern = '/^([a-zA-Z]+)(\w*)$/'; $min = 2; $max = 20;
        if(!empty($username)) {
            if(!preg_match($pattern, $username)) {
                throw new Exception("Invalid username pattern");
            } elseif(strlen($username) < $min) {
                throw new Exception("The username is too short");
            } elseif(strlen($username) > $max) {
                throw new Exception("The username is too long");
            }
            return $this->username = trim($username);
        }
        throw new Exception("The username is required");
    }
    
    /**
     * setEmail
     *
     * @param  string $email
     * @return string
     */
    public function setEmail(string $email) 
    {
        if(isset($email)) {
            filter_var($email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address");
            }
        } else {
            throw new Exception("The email is required");
        }
        return $this->email = trim($email);
    }

    public function setPassword(string $password) 
    {
        $min = 6; $max = 60;
        if(!empty($password)) {
            if(strlen($password) < $min) {
                throw new Exception("The password  cannot be less than 6 characters long");
            } elseif(strlen($password) > $max) {
                throw new Exception("The password  cannot be longer than 60 characters");
            }
        } else {
            throw new Exception("The password is required");
        }
       return $this->password = $password;
    }
    
    /**
     * setStatus
     *
     * @param  string $active
     * @return string
     */
    public function setStatus(string $active) 
    {
        if(strtoupper($active) !== 'Y' && strtoupper($active) !== 'N') {
            throw new Exception("Status must be either Y or N");
        }
        return $this->active = $active;
    }
    
    /**
     * setPhone
     *
     * @param  string $phone
     * @return string
     */
    public function setPhone(string $phone) 
    {
        $min = 3; $max = 14; $pattern = '/^((\+[1-9]+)$|([0-9]+)$)/';
        if(!empty($phone)) {
            if(!preg_match($pattern, $phone)) {
                throw new Exception("Invalid phone format");
            } elseif(strlen($phone) < $min) {
                throw new Exception("The phone number is too short");
            } elseif(strlen($phone) > $max) {
                throw new Exception("The phone number is too long");
            }
            return $this->phone = trim($phone);
        }
        throw new Exception("The phone is required");
    }
    
       
    /**
     * setCreatedAt
     *
     * @param  string $createdAt
     * @return string
     */
    public function setCreatedAt(?string $createdAt = '') 
    {
        if(($createdAt !== null) && !date_create_from_format('d-m-Y H:i', $createdAt) || date_format(date_create_from_format('d-m-Y H:i', $createdAt), 'd-m-Y H:i') !== $createdAt) {
			throw new Exception("Invalid date format");
	  }
	  return $this->createdAt = $createdAt;
    }
        
    /**
     * setUpdatedAt
     *
     * @param  string|null $updatedAt
     * @return string
     */
    public function setUpdatedAt(?string $updatedAt = '') 
    {
	  return $this->updatedAt = $updatedAt;
    }
    
    /**
     * returnUserAsArray
     *
     * @return array
     */
    public function toArray() 
    {
        $user = [];
        $user['id'] = $this->getId();
        $user['firstname'] = $this->getFirstname();
        $user['lastname'] = $this->getLastname();
        $user['email'] = $this->getEmail();
        $user['password'] = $this->getPassword();
        $user['active'] = $this->getStatus();
        $user['phone'] = $this->getPhone();
        $user['created_at'] = $this->getCreatedAt();
        $user['updated_at'] = $this->getUpdatedAt();
        return $user;
    }
}
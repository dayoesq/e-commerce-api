<?php

declare(strict_types = 1);

require_once "UserException.php";

class User extends UserException 
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
    private $date;
        
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
    public function getDate() 
    {
        return $this->date;
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
            throw new UserException("User ID Error");
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
        (int)$min = 1; (int)$max = 30;
        if($firstname !== null) {
            if(is_string($firstname)) {
                if(strlen($firstname) < $min) {
                    throw new UserException("The firstname cannot be empty");
                } elseif(strlen($firstname) > $max) {
                    throw new UserException("The firstname is too long");
                } elseif(!preg_match('/^[a-zA-Z]+$/', $firstname)) {
                    throw new UserException("Invalid name format");
                }
            }
           return $this->firstname = trim(ucfirst(strtolower($firstname)));
        } 
        throw new UserException("The firstname is required");
    }
    
    /**
     * setLastname
     *
     * @param  string $lastname
     * @return string
     */
    public function setLastname(string $lastname) 
    {
        (int)$min = 1; (int)$max = 30; $pattern = '/^[a-zA-Z]+$/';
        if(!empty($lastname)) {
            if(is_string($lastname)) {
                if(strlen($lastname) < $min) {
                    throw new UserException("The lastname cannot be empty");
                } elseif(strlen($lastname) > $max) {
                    throw new UserException("The lastname is too long");
                } elseif(!preg_match($pattern, $lastname)) {
                    throw new UserException("Invalid name format");
                }
            }
            return $this->lastname = trim(ucfirst(strtolower($lastname)));
        }
        throw new UserException("The lastname is required");
    }
    
    /**
     * setUsername
     *
     * @param  string $username
     * @return string
     */
    public function setUsername(string $username) 
    {
        (string)$pattern = '/^([a-zA-Z]+)(\w*)$/'; (int)$min = 2; (int)$max = 20;
        if(!empty($username)) {
            if(!preg_match($pattern, $username)) {
                throw new UserException("Invalid username pattern");
            } elseif(strlen($username) < $min) {
                throw new UserException("The username is too short");
            } elseif(strlen($username) > $max) {
                throw new UserException("The username is too long");
            }
            return $this->username = trim($username);
        }
        throw new UserException("The username is required");
    }
    
    /**
     * setEmail
     *
     * @param  string $email
     * @return string
     */
    public function setEmail(string $email) 
    {
        if($email !== null) {
            filter_var($email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new UserException("Invalid email address");
            }
        } else {
            throw new UserException("The email is required");
        }
        return $this->email = trim($email);
    }

    public function setPassword(string $password) 
    {
        (int)$min = 6; (int)$max = 60;
        if(!empty($password)) {
            if(strlen($password) < $min) {
                throw new UserException("The password  cannot be less than 6 characters long");
            } elseif(strlen($password) > $max) {
                throw new UserException("The password  cannot be longer than 60 characters");
            }
        } else {
            throw new UserException("The password is required");
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
            throw new UserException("Status must be either Y or N");
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
        (int)$min = 3; (int)$max = 14; $pattern = '/^((\+[1-9]+)$|([0-9]+)$)/';
        if($phone !== null) {
            if(!preg_match($pattern, $phone)) {
                throw new UserException("Invalid phone format");
            } elseif(strlen($phone) < $min) {
                throw new UserException("The phone number is too short");
            } elseif(strlen($phone) > $max) {
                throw new UserException("The phone number is too long");
            }
            return $this->phone = trim($phone);
        }
        throw new UserException("The phone is required");
    }
    
    /**
     * setDate
     * Format the date to the specified format
     * @param  string $date
     * @return string
     */
    public function setDate($date) 
    {
        if(($date !== null) && !date_create_from_format('d-m-Y H:i', $date) || date_format(date_create_from_format('d-m-Y H:i', $date), 'd-m-Y H:i') !== $date) {
			throw new UserException("Invalid date format");
	  }
	  return $this->date = $date;
    }
    
    /**
     * returnUserAsArray
     *
     * @return array
     */
    public function returnUserAsArray() 
    {
        $user = array();
        $user['id'] = $this->getId();
        $user['firstname'] = $this->getFirstname();
        $user['lastname'] = $this->getLastname();
        $user['email'] = $this->getEmail();
        $user['password'] = $this->getPassword();
        $user['active'] = $this->getStatus();
        $user['phone'] = $this->getPhone();
        $user['date'] = $this->getDate();
        return $user;
    }
}
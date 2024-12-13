<?php
class User {
    private $id;
    private $username;
    private $name;
    private $lastName;
    private $dateOfBirth;
    private $email;
    private $password;
    private $creationDate;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = $data['idUser'] ?? null;
            $this->username = $data['username'];
            $this->name = $data['name'];
            $this->lastName = $data['lastName'];
            $this->dateOfBirth = $data['dateOfBirth'];
            $this->email = $data['email'];
            $this->password = $data['password'] ?? null; 
            $this->creationDate = $data['creationDate'] ?? date("Y-m-d H:i:s"); 
        } else {
            throw new InvalidArgumentException("Le constructeur de User attend un tableau associatif.");
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getName() { return $this->name; }
    public function getLastName() { return $this->lastName; }
    public function getDateOfBirth() { return $this->dateOfBirth; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getCreationDate() { return $this->creationDate; }
}
?>

<?php

class UserManager {
    private $_db;

    const USER_EXISTS = "SELECT idUser, username,name, lastName, dateOfBirth, email, password, creationDate 
                         FROM tblUsers 
                         WHERE username = :username AND password = :password";

    const INSERT_USER = "INSERT INTO tblUsers (username, name, lastName, dateOfBirth, email, password, creationDate) 
    VALUES (:username, :nom, :lastName, :dateOfBirth, :courriel, :motPasse, CURRENT_TIMESTAMP)";
    

    const GET_USER_INFO = "SELECT idUser, username, lastName, dateOfBirth, email, creationDate 
                           FROM tblUsers 
                           WHERE idUser = :idUser";

    public function __construct($db) { 
        $this->setDb($db); 
    }

    private function setDb($db) {
        if (!$db instanceof PDO) {
            throw new InvalidArgumentException("L'objet passé doit être une instance de PDO.");
        }
        $this->_db = $db;
    }

    public function userExists(string $user, string $password) {
        $query = $this->_db->prepare(self::USER_EXISTS);
        $query->execute([
            ':username' => $user,
            ':password' => $password
        ]);
    
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new User($result); 
        }
        return null;
    }
    

    public function createUser(User $userObj) {
        $query = $this->_db->prepare(self::INSERT_USER);
    
        $query->bindValue(':username', $userObj->getUsername());
        $query->bindValue(':nom', $userObj->getName()); 
        $query->bindValue(':lastName', $userObj->getLastName());
        $query->bindValue(':dateOfBirth', $userObj->getDateOfBirth());
        $query->bindValue(':courriel', $userObj->getEmail());
        $query->bindValue(':motPasse', $userObj->getPassword());
    
        $query->execute();
    
        return $this->_db->lastInsertId();
    }
    

    public function getUserInfo($idUser) {
        $query = $this->_db->prepare(self::GET_USER_INFO);
        $query->execute([':idUser' => $idUser]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new User(
                $result['username'],
                $result['name'],
                $result['lastName'],
                $result['dateOfBirth'],
                $result['email'],
                null, 
                $result['creationDate']
            );
        }
        return null;
    }
}
?>

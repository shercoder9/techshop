<?php 
class Order {
    private $id;
    private $userId;
    private $total;
    private $creationDate;

    public function __construct($id, $userId, $total, $creationDate) {
        $this->id = $id;
        $this->userId = $userId;
        $this->total = $total;
        $this->creationDate = $creationDate;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getTotal() { return $this->total; }
    public function getCreationDate() { return $this->creationDate; }
}

?>
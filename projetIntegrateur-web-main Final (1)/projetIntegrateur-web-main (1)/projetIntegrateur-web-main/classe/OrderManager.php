<?php
class OrderManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createOrder($userId, $total) {
        $sql = "INSERT INTO Orders (user_id, total, creation_date) VALUES (?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $total]);
    }
}

?>
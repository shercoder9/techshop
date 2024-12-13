<?php
class OrderItemManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addOrderItem($orderId, $productId, $quantity) {
        $sql = "INSERT INTO Order_Items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId, $productId, $quantity]);
    }

    public function getItemsByOrderId($orderId) {
        $sql = "SELECT * FROM Order_Items WHERE order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>
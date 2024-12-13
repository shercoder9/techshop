<?php
class OrderItem {
    private $id;
    private $orderId;
    private $productId;
    private $quantity;

    public function __construct($id, $orderId, $productId, $quantity) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getOrderId() { return $this->orderId; }
    public function getProductId() { return $this->productId; }
    public function getQuantity() { return $this->quantity; }
}

?>
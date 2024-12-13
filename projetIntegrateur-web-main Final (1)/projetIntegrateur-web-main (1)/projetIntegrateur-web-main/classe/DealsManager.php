<?php
 
class DealsManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createDeal($idProduct, $description, $discountPrice, $startDate, $endDate) {
        $sql = "INSERT INTO tblDeals (idProduct, description, discountPrice, startDate, endDate) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idProduct, $description, $discountPrice, $startDate, $endDate]);
    }

    public function getAllDeals() {
        $sql = "SELECT * FROM tblDeals";
        $stmt = $this->pdo->query($sql);
        $deals = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $deals[] = new Deals($data['id'], $data['idProduct'], $data['description'], $data['discountPrice'], $data['startDate'], $data['endDate']);
        }
        return $deals;
    }
}


?>
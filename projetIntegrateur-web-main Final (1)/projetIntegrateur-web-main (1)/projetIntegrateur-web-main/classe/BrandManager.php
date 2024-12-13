<?php
class BrandManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createBrand($name, $description) {
        $sql = "INSERT INTO Brands (name, description) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $description]);
    }

    public function getAllBrands() {
        $sql = "SELECT * FROM Brands";
        $stmt = $this->pdo->query($sql);
        $brands = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $brands[] = new Brand($data['id'], $data['name'], $data['description']);
        }
        return $brands;
    }
}

?>
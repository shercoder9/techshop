<?php
class CategoryManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createCategory($name, $description) {
        $sql = "INSERT INTO Category (name, description) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $description]);
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM Category";
        $stmt = $this->pdo->query($sql);
        $categories = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($data['id'], $data['name'], $data['description']);
        }
        return $categories;
    }
}

?>
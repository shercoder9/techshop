<?php
class ProductManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getFilteredProducts($filters = []) {
        try {
            $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                    FROM tblProducts p
                    LEFT JOIN tblCategory c ON p.idCategory = c.idCategory
                    LEFT JOIN tblBrands b ON p.idBrand = b.idBrand
                    WHERE 1=1";
            
            $params = [];
            if (!empty($filters['category'])) {
                $sql .= " AND p.idCategory = :category";
                $params[':category'] = $filters['category'];
            }

            if (!empty($filters['min_price'])) {
                $sql .= " AND p.price >= :min_price";
                $params[':min_price'] = $filters['min_price'];
            }

            if (!empty($filters['max_price'])) {
                $sql .= " AND p.price <= :max_price";
                $params[':max_price'] = $filters['max_price'];
            }

            if (!empty($filters['brand'])) {
                $sql .= " AND p.idBrand = :brand";
                $params[':brand'] = $filters['brand'];
            }

            if (!empty($filters['in_stock'])) {
                $sql .= " AND p.stock > 0";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            $products = [];
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product(
                    $data['idProduct'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['idBrand'],
                    $data['idCategory'],
                    $data['stock'],
                    $data['image']
                );
            }

            return $products;
        } catch (PDOException $e) {
            error_log("Filtered Products Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllCategories() {
        try {
            $sql = "SELECT * FROM tblCategory";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Categories Fetch Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllBrands() {
        try {
            $sql = "SELECT * FROM tblBrands";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Brands Fetch Error: " . $e->getMessage());
            return [];
        }
    }
    public function getBrandById($id) {
        try {
            $sql = $this->pdo->prepare("SELECT name FROM tblBrands WHERE idBrand = :id");
            $sql->execute(array(':id' => $id));
            $bddResult = $sql->fetch();
            return $bddResult["name"];
        } catch (PDOException $e) {
            error_log("Brands Fetch Error: " . $e->getMessage());
            return [];
        }
    }
    public function getProductById($id) {
        try {
            $sql = "SELECT * FROM tblProducts WHERE idProduct = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                return new Product(
                    $data['idProduct'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['idBrand'],
                    $data['idCategory'],
                    $data['stock'],
                    $data['image']
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Product Fetch Error: " . $e->getMessage());
            return null;
        }
    }
    public function getCategoryById($id) {
        try {
            $sql = $this->pdo->prepare("SELECT name FROM tblCategory WHERE idCategory = :id");
            $sql->execute([':id' => $id]);
            $result = $sql->fetch();
            return $result ? $result['name'] : null;
        } catch (PDOException $e) {
            error_log("Category Fetch Error: " . $e->getMessage());
            return null;
        }
    }
    public function getDeals($filters) {
        try {
            $sql = "SELECT p.*, d.discountPrice, d.endDate, d.description as dealDescription
                    FROM tblDeals d
                    JOIN tblProducts p ON d.idProduct = p.idProduct
                    WHERE d.endDate >= CURRENT_DATE()";
            $params = [];
            if (!empty($filters['category'])) {
                $sql .= " AND p.idCategory = :category";
                $params[':category'] = $filters['category'];
            }

            if (!empty($filters['min_price'])) {
                $sql .= " AND p.price >= :min_price";
                $params[':min_price'] = $filters['min_price'];
            }

            if (!empty($filters['max_price'])) {
                $sql .= " AND p.price <= :max_price";
                $params[':max_price'] = $filters['max_price'];
            }

            if (!empty($filters['brand'])) {
                $sql .= " AND p.idBrand = :brand";
                $params[':brand'] = $filters['brand'];
            }

            if (!empty($filters['in_stock'])) {
                $sql .= " AND p.stock > 0";
            }
            $sql .= " ORDER BY d.endDate ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $deals = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $discount = round((($row['price'] - $row['discountPrice']) / $row['price']) * 100);
                $deals[] = [
                    'product' => new Product(
                        $row['idProduct'],
                        $row['name'],
                        $row['description'],
                        $row['price'],
                        $row['idBrand'],
                        $row['idCategory'],
                        $row['stock'],
                        $row['image']
                    ),
                    'discountPrice' => $row['discountPrice'],
                    'endDate' => $row['endDate'],
                    'discountPercentage' => $discount
                ];
            }
            return $deals;
        } catch (PDOException $e) {
            error_log("Deals Fetch Error: " . $e->getMessage());
            return [];
        }
    }
    public function searchProducts($searchTerm) {
        try {
            $sql = "SELECT p.*, b.name as brandName, c.name as categoryName 
                    FROM tblProducts p
                    LEFT JOIN tblBrands b ON p.idBrand = b.idBrand
                    LEFT JOIN tblCategory c ON p.idCategory = c.idCategory
                    WHERE p.name LIKE :search 
                    OR p.description LIKE :search 
                    OR b.name LIKE :search 
                    OR c.name LIKE :search";
            
            $stmt = $this->pdo->prepare($sql);
            $searchTerm = '%' . $searchTerm . '%';
            $stmt->execute([':search' => $searchTerm]);
            
            $products = [];
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product(
                    $data['idProduct'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['idBrand'],
                    $data['idCategory'],
                    $data['stock'],
                    $data['image']
                );
            }
            
            return $products;
        } catch (PDOException $e) {
            error_log("Search Error: " . $e->getMessage());
            return [];
        }
    }
}

?>
<?php
class Cart {
    private $items = [];
    private $pdo;
    private $userId = null;

    public function __construct($pdo) {
        error_log("Cart constructor called");
        $this->pdo = $pdo;
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            error_log("Initialized empty session cart");
        }
        $this->items = $_SESSION['cart'];
        error_log("Loaded items from session: " . print_r($this->items, true));

        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->userId = $user->getId();
            $this->loadCartFromDatabase();
        }
    }

    private function loadCartFromSession() {
        error_log("Loading cart from session");
        if (isset($_SESSION['cart'])) {
            $this->items = $_SESSION['cart'];
            error_log("Loaded items: " . print_r($this->items, true));
        } else {
            $this->items = [];
            error_log("No cart in session, initialized empty array");
        }
    }

    private function loadCartFromDatabase() {
        error_log("Loading cart from database for user: " . $this->userId);
        try {
            $stmt = $this->pdo->prepare("SELECT productId, quantity FROM tblCart WHERE userId = ?");
            $stmt->execute([$this->userId]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($cartItems as $item) {
                $this->items[$item['productId']] = $item['quantity'];
            }
            error_log("Loaded items from database: " . print_r($this->items, true));
        } catch (PDOException $e) {
            error_log("Cart Load Error: " . $e->getMessage());
        }
    }

    public function addItem($productId, $quantity = 1) {
        error_log("Adding item: Product ID = $productId, Quantity = $quantity");
        error_log("Current items before adding: " . print_r($this->items, true));

        if (isset($this->items[$productId])) {
            $this->items[$productId] += $quantity;
        } else {
            $this->items[$productId] = $quantity;
        }
        
        error_log("Items after adding: " . print_r($this->items, true));
        $this->saveCart();
        error_log("Session cart after save: " . print_r($_SESSION['cart'], true));
    }

    private function saveCart() {
        error_log("Saving cart - Items to save: " . print_r($this->items, true));
        
        if ($this->userId) {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM tblCart WHERE userId = ?");
                $stmt->execute([$this->userId]);

                if (!empty($this->items)) {
                    $stmt = $this->pdo->prepare("INSERT INTO tblCart (userId, productId, quantity) VALUES (?, ?, ?)");
                    foreach ($this->items as $productId => $quantity) {
                        $stmt->execute([$this->userId, $productId, $quantity]);
                    }
                }
            } catch (PDOException $e) {
                error_log("Cart Save Error: " . $e->getMessage());
            }
        }
        
        $_SESSION['cart'] = $this->items;
        error_log("Saved to session - Current session cart: " . print_r($_SESSION['cart'], true));
    }

    public function removeItem($productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
            $this->saveCart();
        }
    }

    public function updateQuantity($productId, $quantity) {
        if ($quantity <= 0) {
            $this->removeItem($productId);
        } else {
            $this->items[$productId] = $quantity;
            $this->saveCart();
        }
    }



    public function getItems() {
        $cartItems = [];
        foreach ($this->items as $productId => $quantity) {
            $stmt = $this->pdo->prepare("SELECT * FROM tblProducts WHERE idProduct = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $cartItems[] = [
                    'product' => new Product(
                        $product['idProduct'],
                        $product['name'],
                        $product['description'],
                        $product['price'],
                        $product['idBrand'],
                        $product['idCategory'],
                        $product['stock'],
                        $product['image']
                    ),
                    'quantity' => $quantity
                ];
            }
        }
        return $cartItems;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function clear() {
        $this->items = [];
        $this->saveCart();
    }

    public function getItemCount() {
        return count($this->items);
    }

    public function mergeWithUserCart($userId) {
        $this->userId = $userId;
        $sessionCart = $this->items;
        $this->loadCartFromDatabase();
        
        foreach ($sessionCart as $productId => $quantity) {
            if (isset($this->items[$productId])) {
                $this->items[$productId] += $quantity;
            } else {
                $this->items[$productId] = $quantity;
            }
        }
        
        $this->saveCart();
        unset($_SESSION['cart']);
    }
}
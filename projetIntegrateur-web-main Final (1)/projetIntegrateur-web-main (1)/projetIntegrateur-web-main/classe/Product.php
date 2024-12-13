<?php
class Product {
    private $idProduct;
    private $name;
    private $description;
    private $price;
    private $idBrand;
    private $idCategory;
    private $stock;
    private $image;

    public function __construct($idProduct, $name, $description, $price, $idBrand, $idCategory, $stock, $image) {
        $this->idProduct = $idProduct;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->idBrand = $idBrand;
        $this->idCategory = $idCategory;
        $this->stock = $stock;
        $this->image = $image;
    }
    public function getIdProduct() {
        return $this->idProduct;
    }
    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getBrandId() { return $this->brandId; }
    public function getCategoryId() { return $this->categoryId; }
    public function getStock() { return $this->stock; }
    public function getImage() { return $this->image; } 
    

    // Setters
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setPrice($price) { $this->price = $price; }
    public function setBrandId($brandId) { $this->brandId = $brandId; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
    public function setStock($stock) { $this->stock = $stock; }
    public function setImage($image) { $this->image = $image; } 
}
?>

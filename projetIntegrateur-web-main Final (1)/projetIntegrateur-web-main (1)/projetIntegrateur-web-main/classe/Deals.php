<?php 
class Deals {
    private $id;
    private $name;
    private $description;
    private $discountPrice;
    private $startDate;
    private $endDate;

    public function __construct($id, $name, $description, $discountPrice, $startDate, $endDate) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->discountPrice = $discountPrice;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getDiscountPrice() { return $this->discountPrice; }
    public function getStartDate() { return $this->startDate; }
    public function getEndDate() { return $this->endDate; }

    // Setters 
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setDiscountPrice($discountPrice) { $this->discountPrice = $discountPrice; }
    public function setStartDate($startDate) { $this->startDate = $startDate; }
    public function setEndDate($endDate) { $this->endDate = $endDate; }
}

?>
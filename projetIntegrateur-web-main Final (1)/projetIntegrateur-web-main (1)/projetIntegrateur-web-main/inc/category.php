<?php
include_once("../inc/header.php");
include_once("../inc/product_display.php");

$categoryMap = [
    'laptops' => 1,
    'phones' => 2,
    'tablets' => 3,
    'tvs' => 4,
    'accessories' => 5,
    'gaming-consoles' => 6
];

$categorySlug = basename($_SERVER['PHP_SELF'], '.php');
$categoryId = $categoryMap[$categorySlug] ?? null;

if ($categoryId === null) {
    die("Invalid category");
}

$productManager = new ProductManager($bdd);
$filters = ['category' => $categoryId];

$categories = $productManager->getAllCategories();
$categoryName = 'Unknown Category';
foreach ($categories as $cat) {
    if ($cat['idCategory'] == $categoryId) {
        $categoryName = $cat['name'];
        break;
    }
}
?>

<div class="category-header">
    <h1><?php echo htmlspecialchars($categoryName); ?></h1>
</div>

<?php
displayProducts($productManager, $filters, $categoryName . ' Products');
include_once("../inc/footer.php");
?>
<?php
include_once("../inc/header.php");
include_once("../inc/product_display.php");

$brandMap = [
    'apple' => 1,
    'samsung' => 2,
    'dell' => 3,
    'sony' => 4,
    'microsoft' => 5,
    'logitech' => 6
];

$brandSlug = basename($_SERVER['PHP_SELF'], '.php');
$brandId = $brandMap[$brandSlug] ?? null;

if ($brandId === null) {
    die("Invalid brand");
}

$productManager = new ProductManager($bdd);
$filters = ['brand' => $brandId];

$brands = $productManager->getAllBrands();
$brandName = 'Unknown Brand';
foreach ($brands as $brand) {
    if ($brand['idBrand'] == $brandId) {
        $brandName = $brand['name'];
        break;
    }
}
?>

<div class="brand-header">
    <h1><?php echo htmlspecialchars($brandName); ?> Products</h1>
</div>

<?php
displayProducts($productManager, $filters, $brandName . ' Products');
include_once("../inc/footer.php");
?>
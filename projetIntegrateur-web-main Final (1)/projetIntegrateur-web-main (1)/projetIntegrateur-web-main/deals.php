<?php include_once("inc/header.php"); ?>
<?php
$page = "deals.php";
include_once("inc/filter.php");

$filters = [];
if (!empty($_GET['category'])) {
    $filters['category'] = intval($_GET['category']);
}
if (!empty($_GET['brand'])) {
    $filters['brand'] = intval($_GET['brand']);
}
if (!empty($_GET['min_price'])) {
    $filters['min_price'] = floatval($_GET['min_price']);
}
if (!empty($_GET['max_price'])) {
    $filters['max_price'] = floatval($_GET['max_price']);
}
if (isset($_GET['in_stock'])) {
    $filters['in_stock'] = 1;
}

// Fetch filtered products
$allProducts = $productManager->getDeals($filters);

// Display products
if (empty($allProducts)) {
    echo '<p class="text-center">No products found matching the selected filters.</p>';
}
else
{ 
    ?>
<div class="product-container">
    <h2><?php echo 'All Deals'; ?></h2>
    <div class="products">
    <?php

foreach ($allProducts as $product):
    ?>
        <div class="product-card deals-product-card">
            <img src="./img/<?php echo htmlspecialchars($product["product"]->getImage()); ?>" 
                 alt="<?php echo htmlspecialchars($product["product"]->getName()); ?>">
            <h3><?php echo htmlspecialchars($product["product"]->getName()); ?></h3>
            <p><?php echo htmlspecialchars($product["product"]->getDescription()); ?></p>
            <p class="dealsprice"><?php echo "ÉPARGNEZ " . number_format($product["discountPrice"], 2); ?> $ <br/>
            <?php echo number_format($product["product"]->getPrice(), 2); ?> $</p>
            <p class="stock">Stock: <?php echo $product["product"]->getStock(); ?></p>
            <p class="deals-timer" value="<?php echo ' ' . $product["endDate"] . ' ';?>">L'offre se termine dans</p> 
            <form method="POST" action="traitement.php">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?php echo $product["product"]->getIdProduct(); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; 
?>
    </div>
</div>
<?php
}
?>

<?php include_once("inc/footer.php"); ?>

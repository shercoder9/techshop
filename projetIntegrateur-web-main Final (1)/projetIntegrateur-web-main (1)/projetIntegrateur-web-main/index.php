<?php 
$page = "index.php";
include_once("inc/header.php");
?> 

<div class="sale-banner">
    <div class="banner-content">
        <span class="special-text">SPECIAL OFFER</span>
        <h2 class="big-text">BIG SALE</h2>
        <span class="discount-text">UP TO 50% OFF</span>
        <span class="limited-text">LIMITED QUANTITES</span>
    </div>
</div>

<?php include("inc/filter.php"); ?>


<div class="product-container">
    <h2>Featured Products</h2>
    <div class="products">
        <?php
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

        $allProducts = $productManager->getFilteredProducts($filters);

        if (empty($allProducts)) {
            echo "<p>No products found matching the selected filters.</p>";
        }

        foreach ($allProducts as $product):
        ?>
           <div class="product-card">
                <img src="./img/<?php echo htmlspecialchars($product->getImage()); ?>" 
                    alt="<?php echo htmlspecialchars($product->getName()); ?>">
                <h3><?php echo htmlspecialchars($product->getName()); ?></h3>
                <p><?php echo htmlspecialchars($product->getDescription()); ?></p>
                <p class="price"><?php echo number_format($product->getPrice(), 2); ?> $</p>
                <p class="stock">Stock: <?php echo $product->getStock(); ?></p>
                <form method="POST" action="traitement.php">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" name="product_id" value="<?php echo $product->getIdProduct(); ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once("inc/footer.php"); ?>
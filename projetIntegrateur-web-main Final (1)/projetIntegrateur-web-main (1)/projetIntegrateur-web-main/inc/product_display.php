<?php
function displayProducts($productManager, $filters = [], $pageTitle = 'Products') {
    ?>
    <div class="product-container">
        <h2><?php echo htmlspecialchars($pageTitle); ?></h2>
        <div class="products">
            <?php
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
    <?php
}
?>
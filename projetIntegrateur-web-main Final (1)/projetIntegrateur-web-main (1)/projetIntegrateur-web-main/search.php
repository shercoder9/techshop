<?php
include_once("inc/header.php");

$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
$productManager = new ProductManager($bdd);

if (!empty($searchTerm)) {
    $searchResults = $productManager->searchProducts($searchTerm);
}
?>

<div class="search-results-container">
    <?php if (!empty($searchTerm)): ?>
        <h1>Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h1>
        
        <?php if (!empty($searchResults)): ?>
            <p class="results-count"><?php echo count($searchResults); ?> products found</p>
            <div class="products">
                <?php foreach ($searchResults as $product): ?>
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
        <?php else: ?>
            <p class="no-results">No products found matching your search.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>


<?php include_once("inc/footer.php"); ?>
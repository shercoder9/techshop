<?php 
include_once("inc/header.php");
$page = "brands.php";

$productManager = new ProductManager($bdd);
$filters = [];

if (isset($_GET['brand']) && $_GET['brand'] != 0) {
    $brandId = intval($_GET['brand']);
    $brandName = $productManager->getBrandById($brandId);
    if ($brandName) {
        $filters['brand'] = $brandId;
        echo '<h1 class="text-center">' . htmlspecialchars($brandName) . "</h1>";
    }
}
else{
    $brandId = 0; 
}

if (!empty($_GET['category'])) $filters['category'] = intval($_GET['category']);
if (!empty($_GET['min_price'])) $filters['min_price'] = floatval($_GET['min_price']);
if (!empty($_GET['max_price'])) $filters['max_price'] = floatval($_GET['max_price']);
if (isset($_GET['in_stock'])) $filters['in_stock'] = 1;
?>

<div class="filter-container">
    <form method="GET" action="" class="filter-form">
        <input type="hidden" name="brand" value="<?php echo $brandId; ?>">
        <div class="filter-row">
            <div class="filter-group">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <?php
                    $categories = $productManager->getAllCategories();
                    foreach ($categories as $category):
                    ?>
                        <option value="<?php echo $category['idCategory']; ?>" 
                            <?php echo (isset($_GET['category']) && $_GET['category'] == $category['idCategory']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="min_price">Min Price:</label>
                <input type="number" name="min_price" id="min_price" min="0" step="0.01" 
                       value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
            </div>
            <div class="filter-group">
                <label for="max_price">Max Price:</label>
                <input type="number" name="max_price" id="max_price" min="0" step="0.01"
                       value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
            </div>

            <div class="filter-group">
                <label for="in_stock">In Stock Only:</label>
                <input type="checkbox" name="in_stock" id="in_stock" value="1" 
                       <?php echo isset($_GET['in_stock']) ? 'checked' : ''; ?>>
            </div>

            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="brands.php?brand=<?php echo $brandId; ?>" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<?php
include_once("inc/product_display.php");
displayProducts($productManager, $filters);

include_once("inc/footer.php");
?>
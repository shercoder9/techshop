<?php 
include_once("inc/header.php");
$page = "shop.php";

$productManager = new ProductManager($bdd);
$filters = [];

if (isset($_GET['category'])) {
    $categoryId = intval($_GET['category']);
    $categoryName = $productManager->getCategoryById($categoryId);
    if ($categoryName) {
        $filters['category'] = $categoryId;
        echo '<h1 class="text-center">' . htmlspecialchars($categoryName) . "</h1>";
    }
}

if (!empty($_GET['brand'])) $filters['brand'] = intval($_GET['brand']);
if (!empty($_GET['min_price'])) $filters['min_price'] = floatval($_GET['min_price']);
if (!empty($_GET['max_price'])) $filters['max_price'] = floatval($_GET['max_price']);
if (isset($_GET['in_stock'])) $filters['in_stock'] = 1;
?>

<div class="filter-container">
    <form method="GET" action="" class="filter-form">
        <input type="hidden" name="category" value="<?php echo $categoryId; ?>">
        <div class="filter-row">
            <div class="filter-group">
                <label for="brand">Brand:</label>
                <select name="brand" id="brand">
                    <option value="">All Brands</option>
                    <?php
                    $brands = $productManager->getAllBrands();
                    foreach ($brands as $brand):
                    ?>
                        <option value="<?php echo $brand['idBrand']; ?>" 
                            <?php echo (isset($_GET['brand']) && $_GET['brand'] == $brand['idBrand']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($brand['name']); ?>
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
                <a href="shop.php?category=<?php echo $categoryId; ?>" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<?php
include_once("inc/product_display.php");
displayProducts($productManager, $filters);

include_once("inc/footer.php");
?>
<div class="filter-container">
    <form method="GET" action="" class="filter-form">
        <div class="filter-row">
            <div class="filter-group">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <?php
                    $productManager = new ProductManager($bdd);
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
            <?php ?>
            <?php if(isset($page) && $page !== "brands.php"){?>
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
            <?php } ?>
            <div class="filter-group">
                <label for="min_price">Min Price:</label>
                <input type="number" 
                       name="min_price" 
                       id="min_price" 
                       min="0" 
                       step="0.01" 
                       value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>"
                       placeholder="Min Price">
            </div>
            <div class="filter-group">
                <label for="max_price">Max Price:</label>
                <input type="number" 
                       name="max_price" 
                       id="max_price" 
                       min="0" 
                       step="0.01" 
                       value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>"
                       placeholder="Max Price">
            </div>
            <div class="filter-group">
                <label for="in_stock">In Stock Only:</label>
                <input type="checkbox" 
                       name="in_stock" 
                       id="in_stock" 
                       value="1" 
                       <?php echo isset($_GET['in_stock']) ? 'checked' : ''; ?>>
            </div>

            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <?php 
                if($page == "deals.php")
                $valResButtn = "deals.php";
                else {
                    $valResButtn = "index.php";
                }
                
                ?>
                <a href="<?php echo $valResButtn ?>" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

include_once("inc/autoloader.php");
include_once("classe/PDOFactory.php");include_once("classe/Cart.php"); 

$bdd = PDOFactory::getMySQLConnection();
$cart = new Cart($bdd);
$itemCount = $cart->getItemCount();
?>

<!DOCTYPE html>
<html lang="en">

<div class="container">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Tech Shop</title>
    <script src="script.js" defer></script>
</head>

<body>
    
<header>
    <!-- Burger Menu for Mobile -->
    <div class="burger-menu" onclick="toggleMobileMenu()">
        <div class="burger-line"></div>
        <div class="burger-line"></div>
        <div class="burger-line"></div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <span class="close-menu" onclick="toggleMobileMenu()">&times;</span>
        <div class="mobile-menu-content">
            <ul>
                <li><a href="./">Home</a></li>
                <li>
                    <a href="./shop.php">Category ↴</a>
                    <ul class="dropdown">
                        <?php
                        $prodMng = new ProductManager($bdd);
                        $categories = $prodMng->getAllCategories();
                        foreach($categories as $category) {
                            echo '<li><a href="./shop.php?category=' . htmlspecialchars($category["idCategory"]) . '">' . htmlspecialchars($category["name"]) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="./brands.php">Brands ↴</a>
                    <ul class="dropdown">
                        <?php
                        $brands = $prodMng->getAllBrands();
                        foreach($brands as $brand) {
                            echo '<li><a href="./brands.php?brand=' . htmlspecialchars($brand["idBrand"]) . '">' . htmlspecialchars($brand["name"]) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="./map.php">Store Locator</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="traitement.php?action=logout">Sign Out</a></li>
                <?php else: ?>
                    <li><a href="./login.php">Sign In</a></li>
                <?php endif; ?>
                <li><a href="cart.php">Cart (<span id="cartCount"><?php echo $itemCount; ?></span>)</a></li>
            </ul>
        </div>
    </div>
    
        <div class="mid-header">
            <a href="./" class="logo"><img src="./img/logo.png" alt="Website logo"></a>
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="search" name="q" placeholder="Search for products, categories, brands" 
                        value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                    <button type="submit"><p>⌕</p></button>
                </form>
            </div>
            <div class="user-menu">
                <a href="./map.php">Store Locator <img src="./img/location.png" alt="Location icon" class="menu-icon"></a>
                <?php if (isset($_SESSION['user'])):  ?>
                    <a href="traitement.php?action=logout">Sign Out <img src="./img/login.png" alt="Logout icon" class="menu-icon"></a>
                <?php else: ?>
        <a href="./login.php">Sign In <img src="./img/login.png" alt="Login icon" class="menu-icon"></a>
    <?php endif; ?>
    <?php 
            
            ?>
            <a href="cart.php">Cart (<span id="cartCount"><?php echo $itemCount; ?></span>) <img src="./img/cart.png" alt="Cart icon" class="menu-icon"></a>
            </div>
        </div>

        <div class="deal-timer">
            <div class="time">
                <div id="day">00</div>
                <div id="hour">00</div>
                <div id="minute">00</div>
                <div id="second">00</div>
            </div>
            <p>BLACK FRIDAY event is on now, DON'T wait!</p>
        </div>

        <nav class="bottom-header">
            <ul class="main-menu">
                <li><a href="./">Home</a></li>
                <li><a href="./shop.php">Category ↴</a>
                    <ul class="dropdown">
                    <?php
                        include_once("classe/PDOFactory.php");
                        include_once("classe/ProductManager.php");

                        $prodMng = new ProductManager(PDOFactory::getMySQLConnection());
                        $categories = $prodMng->getAllCategories();
                        foreach($categories as $category){
                            echo('<li><a href="./shop.php?category=' .$category["idCategory"] . '">' . htmlspecialchars($category["name"]) . '</a></li>');
                        }
                        ?>

                    </ul>
                </li>
                <li><a href="./brands.php">Brands ↴</a>
                    <ul class="dropdown">
                    <?php
                        
                       
                        $brands = $prodMng->getAllBrands();
                        foreach($brands as $brand){
                            echo('<li><a href="./brands.php?brand=' .$brand["idBrand"] . '">'. htmlspecialchars($brand["name"]) . '</a></li>');
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="./deals.php">Deals</a></li>

            </ul>
        </nav>
    </header>
<main>

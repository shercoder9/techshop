<?php 
include_once("inc/pretraitement.php"); 
include_once("inc/header.php"); 
?>

<div class="message-container">
    <?php 
    if (isset($_REQUEST['action'])) {
        switch ($_REQUEST['action']) {
            case "inscription":
                try {
                    $userManager = new UserManager($bdd);
                    $user = new User($_REQUEST);
                    $userId = $userManager->createUser($user);
                    if ($userId) {
                        echo "<div class='success-message'>
                                <h2>Account Created Successfully!</h2>
                                <p>Welcome to TechShop. You can now log in with your credentials.</p>
                                <a href='login.php' class='btn'>Log In</a>
                            </div>";
                    }
                } catch (Exception $e) {
                    echo "<div class='error-message'>Registration failed. Please try again.</div>";
                }
                break;

            case "connexion":
                if (isset($_SESSION['user'])) {
                    $user = unserialize($_SESSION['user']);
                    if (isset($_SESSION['cart'])) {
                        $cart = new Cart($bdd);
                        $cart->mergeWithUserCart($user->getId());
                    }
                    ?>
                    <div class="page-bienvenu">
                        <div class="user-info">
                            <h1>Welcome back, <?= htmlspecialchars($user->getUsername()); ?>!</h1>
                            <h3 class="create-account-section-header">Personal Information</h3>
                            <div class="user-details">
                                <p><strong>Email:</strong> <?= htmlspecialchars($user->getEmail()); ?></p>
                                <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user->getDateOfBirth()); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php 
                } else {
                    $authError = true;
                    include_once("sign_in_form.php");
                }
                break;

            case "logout":
                session_destroy();
                echo "<div class='success-message'>
                        <h2>Successfully Logged Out</h2>
                        <a href='index.php' class='btn'>Return to Home</a>
                      </div>";
                break;

            case "add_to_cart":
                if (isset($_REQUEST['product_id']) && isset($_REQUEST['quantity'])) {
                    $cart = new Cart($bdd); 
                    $productManager = new ProductManager($bdd);  
                    $product = $productManager->getProductById($_REQUEST['product_id']);
                    
                    if ($product && $product->getStock() >= $_REQUEST['quantity']) {
                        error_log("Adding to cart - Product ID: " . $_REQUEST['product_id'] . " Quantity: " . $_REQUEST['quantity']);
                        
                        $cart->addItem($_REQUEST['product_id'], $_REQUEST['quantity']);
                        $newCount = $cart->getItemCount();
                        
                        error_log("New cart count: " . $newCount);
                        error_log("Cart contents: " . print_r($_SESSION['cart'], true));
                        
                        echo "<div class='success-message' data-cart-count='" . $newCount . "'>
                                <h2>Added to Cart</h2>
                                <p>" . htmlspecialchars($product->getName()) . " (x" . $_REQUEST['quantity'] . ")</p>
                                <div class='cart-actions'>
                                    <a href='cart.php' class='btn'>View Cart</a>
                                    <a href='javascript:history.back()' class='btn secondary'>Continue Shopping</a>
                                </div>
                                </div>";
                    }
                }
                break;

                case "update_cart":
                    if (isset($_REQUEST['product_id']) && isset($_REQUEST['quantity'])) {
                        $cart = new Cart($bdd);
                        $productManager = new ProductManager($bdd);
                        $product = $productManager->getProductById($_REQUEST['product_id']);
                        
                        if ($product && $product->getStock() >= $_REQUEST['quantity']) {
                            $cart->updateQuantity($_REQUEST['product_id'], intval($_REQUEST['quantity']));
                            echo "<div class='success-message' data-cart-count='" . $cart->getItemCount() . "'>
                                    <h2>Cart Updated</h2>
                                    <div class='cart-actions'>
                                        <a href='cart.php' class='btn'>Back to Cart</a>
                                    </div>
                                  </div>";
                        } else {
                            echo "<div class='error-message'>
                                    <h2>Error</h2>
                                    <p>Quantity not available in stock.</p>
                                    <a href='cart.php' class='btn'>Back to Cart</a>
                                  </div>";
                        }
                    }
                    break;
                case "remove_from_cart":
                    if (isset($_REQUEST['product_id'])) {
                        $cart = new Cart($bdd);
                        $cart->removeItem($_REQUEST['product_id']);
                        echo "<div class='success-message' data-cart-count='" . $cart->getItemCount() . "'>
                                <h2>Item Removed from Cart</h2>
                                <div class='cart-actions'>
                                    <a href='cart.php' class='btn'>Back to Cart</a>
                                </div>
                                </div>";
                    }
                    break;
            default:
                echo "<div class='error-message'>
                        <h2>Invalid Action</h2>
                        <a href='index.php' class='btn'>Return to Home</a>
                      </div>";
                break;
        }
    }
    ?>
</div>

<?php include_once("inc/footer.php"); ?>
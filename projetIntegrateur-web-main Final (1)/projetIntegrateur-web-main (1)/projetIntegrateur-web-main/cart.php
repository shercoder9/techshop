<?php
include_once("inc/header.php");

$cart = new Cart($bdd);

error_log("Cart initialized. Session cart contents: " . print_r($_SESSION['cart'], true));

if (isset($_POST['action'])) {
    error_log("Cart action received: " . $_POST['action']);
    
    switch ($_POST['action']) {
        case 'update':
            if (isset($_POST['quantity']) && isset($_POST['product_id'])) {
                $cart->updateQuantity($_POST['product_id'], intval($_POST['quantity']));
                error_log("Updated quantity for product " . $_POST['product_id'] . " to " . $_POST['quantity']);
            }
            break;
        case 'remove':
            if (isset($_POST['product_id'])) {
                $cart->removeItem($_POST['product_id']);
                error_log("Removed product " . $_POST['product_id'] . " from cart");
            }
            break;
        case 'clear':
            $cart->clear();
            error_log("Cart cleared");
            break;
    }
}

$cartItems = $cart->getItems();
error_log("Retrieved cart items: " . print_r($cartItems, true));
?>

<div class="cart-container">
    <h1>Shopping Cart</h1>
    
    <?php if (!empty($cartItems)): ?>
        <div class="cart-items">
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <img src="./img/<?php echo htmlspecialchars($item['product']->getImage()); ?>" 
                         alt="<?php echo htmlspecialchars($item['product']->getName()); ?>">
                    
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($item['product']->getName()); ?></h3>
                        <p class="price">$<?php echo number_format($item['product']->getPrice(), 2); ?></p>
                    </div>
                    
                    <div class="item-quantity">
                        <form method="POST" action="traitement.php">
                            <input type="hidden" name="action" value="update_cart">
                            <input type="hidden" name="product_id" value="<?php echo $item['product']->getIdProduct(); ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['product']->getStock(); ?>">
                            <button type="submit" class="update-btn">Update</button>
                        </form>
                    </div>
                    
                    <div class="item-subtotal">
                        $<?php echo number_format($item['product']->getPrice() * $item['quantity'], 2); ?>
                    </div>
                    
                    <form method="POST" action="traitement.php" class="remove-form">
                        <input type="hidden" name="action" value="remove_from_cart">
                        <input type="hidden" name="product_id" value="<?php echo $item['product']->getIdProduct(); ?>">
                        <button type="submit" class="remove-btn">×</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cart-summary">
            <div class="subtotal">
                <span>Subtotal:</span>
                <span>$<?php echo number_format($cart->getTotal(), 2); ?></span>
            </div>
            
            <form method="POST" action="traitement.php" class="clear-cart-form">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="clear-btn">Clear Cart</button>
            </form>
        </div>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty</p>
        <button class="continue-shopping" onclick="location.href='index.php'">
            Continue Shopping
        </button>
    <?php endif; ?>
</div>
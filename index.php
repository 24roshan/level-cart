<?php
session_start();

// Hardcoded products
$products = [
    1 => ['id' => 1, 'name' => 'Laptop', 'price' => 50000],
    2 => ['id' => 2, 'name' => 'Smartphone', 'price' => 20000],
    3 => ['id' => 3, 'name' => 'Headphones', 'price' => 3000],
];

// Initialize flash message helper
function set_flash($msg) {
    $_SESSION['flash'] = $msg;
}
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// Cart operations
$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        if (!isset($products[$id])) {
            set_flash("Invalid product.");
        } else {
            $cart = $_SESSION['cart'] ?? [];
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
            } else {
                $cart[$id] = [
                    'name' => $products[$id]['name'],
                    'price' => $products[$id]['price'],
                    'quantity' => 1,
                ];
            }
            $_SESSION['cart'] = $cart;
            set_flash("Product added to cart!");
        }
        header("Location: /?view=products");
        exit;
    }

    if ($action === 'update' && isset($_POST['id'], $_POST['quantity'])) {
        $id = (int)$_POST['id'];
        $qty = max(1, (int)$_POST['quantity']);
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
            set_flash("Cart updated!");
        }
        header("Location: /?view=cart");
        exit;
    }

    if ($action === 'remove' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['cart'] = $_SESSION['cart']; // reassign to persist
            set_flash("Product removed!");
        }
        header("Location: /?view=cart");
        exit;
    }

    if ($action === 'clear') {
        unset($_SESSION['cart']);
        set_flash("Cart cleared!");
        header("Location: /?view=cart");
        exit;
    }

    if ($action === 'checkout') {
        unset($_SESSION['cart']);
        set_flash("Thank you for your purchase!");
        header("Location: /?view=products");
        exit;
    }
}

// Helper to compute total
function cart_total($cart) {
    $sum = 0;
    foreach ($cart as $item) {
        $sum += $item['price'] * $item['quantity'];
    }
    return $sum;
}

// Determine view
$view = $_GET['view'] ?? 'products';
$cart = $_SESSION['cart'] ?? [];
$flash = get_flash();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mini ECommerce Cart (PHP)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">
    <?php if ($flash): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <?php if ($view === 'products'): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Products</h1>
            <a href="?view=cart" class="btn btn-success">View Cart (<?= array_sum(array_column($cart, 'quantity')) ?>)</a>
        </div>
        <div class="row">
            <?php foreach ($products as $p): ?>
                <div class="col-md-4">
                    <div class="card mb-3 p-3">
                        <h4><?= htmlspecialchars($p['name']) ?></h4>
                        <p>₹<?= number_format($p['price'], 2) ?></p>
                        <form method="POST" action="?action=add&view=products">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($view === 'cart'): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Your Cart</h1>
            <a href="?view=products" class="btn btn-primary">Continue Shopping</a>
        </div>
        <?php if ($cart && count($cart) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:140px;">Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <form method="POST" action="?action=update&view=cart" class="d-flex align-items-center">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="number" name="quantity" min="1" value="<?= $item['quantity'] ?>" class="form-control me-2" style="width:70px;">
                                    <button class="btn btn-sm btn-warning">Update</button>
                                </form>
                            </td>
                            <td>₹<?= number_format($item['price'], 2) ?></td>
                            <td>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td>
                                <form method="POST" action="?action=remove&view=cart">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total: ₹<?= number_format(cart_total($cart), 2) ?></h3>

            <div class="mb-3">
                <form method="POST" action="?action=clear&view=cart" style="display:inline-block;">
                    <button class="btn btn-secondary">Clear Cart</button>
                </form>
                <form method="POST" action="?action=checkout&view=cart" style="display:inline-block;">
                    <button class="btn btn-success">Checkout</button>
                </form>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

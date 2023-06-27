<?php
session_start();
$pageTitle = 'Cart';
include './init.php';
$do = isset($_GET['do']) ? $_GET['do'] : 'cart';
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $cartItems = $_SESSION['cart'];
} else {
  $cartItems = array();
}
if ($do == 'cart') {
?>
  <div class="cart">
    <div class="container">
      <h1>Shopping Cart</h1>
      <?php
      if (isset($_SESSION['message'])) : ?>
        <div id="message">
          <?php echo $_SESSION['message']; ?>
        </div>
      <?php unset($_SESSION['message']);
      endif;
      ?>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="text-bg-light">
              <th>Product Details</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($cartItems)) : ?>
              <?php foreach ($cartItems as $item) : ?>
                <tr>
                  <td><?php echo $item['product_name']; ?></td>
                  <td><?php echo $item['quantity']; ?></td>
                  <td><?php echo $item['product_price']; ?></td>
                  <td><?php echo $item['quantity'] * $item['product_price']; ?></td>
                  <td>
                    <a href="cart.php?do=remove-product&id=<?php echo $item['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i>&nbsp;Remove</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">Your cart is empty.<br /><a class="btn btn-outline-dark" href="./index.php">Return to shop</a></td>
              </tr>
            <?php endif ?>
          </tbody>
          <tfoot>
            <?php
            $subtotal = 0;
            if (!empty($cartItems)) {
              foreach ($cartItems as $item) {
                $subtotal += $item['quantity'] * $item['product_price'];
              }
            }
            ?>
            <tr>
              <td colspan="3">
                <strong>Subtotal:</strong>
              </td>
              <td>
                <strong>
                  <?php echo $subtotal; ?>
                </strong>
              </td>
              <td>
                <a href="cart.php?do=checkout" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i>&nbsp;Checkout</a>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
<?php
} elseif ($do == 'checkout') {
?>
  <div class="checkout">
    <div class="container">
      <h1>Checkout</h1>
      <form method="post" action="cart.php?do=place-order" autocomplete="off" class="py-3">
        <div class="row g-3">
          <div class="col-md-6">
            <h2>Billing Details</h2>
            <?php
            if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif;
            ?>
            <div class="form-group">
              <label for="name_customer">Full Name *</label>
              <input type="text" name="name_customer" id="name_customer" class="form-control" required="required">
            </div>
            <div class="form-group">
              <label for="phone_customer">Phone *</label>
              <input type="tel" name="phone_customer" id="phone_customer" class="form-control" required="required">
            </div>
            <div class="form-group">
              <label for="email_customer">Email Address *</label>
              <input type="email" name="email_customer" id="email_customer" class="form-control" required="required">
            </div>
            <div class="form-group">
              <label for="note_customer">Additional Information</label>
              <textarea name="note_customer" id="note_customer" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <h2>Your Order</h2>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cartItems as $item) : ?>
                    <tr>
                      <td><?php echo $item['product_name']; ?></td>
                      <td><?php echo $item['quantity']; ?></td>
                      <td><?php echo $item['product_price']; ?></td>
                      <td><?php echo $item['quantity'] * $item['product_price']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <?php
                  $subtotal = 0;
                  if (!empty($cartItems)) {
                    foreach ($cartItems as $item) {
                      $subtotal += $item['quantity'] * $item['product_price'];
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="3">
                      <strong>Subtotal:</strong>
                    </td>
                    <td>
                      <strong>
                        <?php echo $subtotal; ?>
                      </strong>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <button type="submit" name="place_order" class="btn btn-primary" disabled><i class="fa-solid fa-check-double"></i>&nbsp;Place Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php
} elseif ($do == 'place-order') {
  if (isset($_POST['place_order'])) {
    $name_customer = $_POST['name_customer'];
    $phone_customer = $_POST['phone_customer'];
    $email_customer = $_POST['email_customer'];
    $note_customer = $_POST['note_customer'];
    $orders_number = generateOrderNumber($con);
    if (empty($name_customer) || empty($phone_customer) || empty($email_customer)) {
      show_message('Please fill in all required fields.', 'danger');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      $customers = $con->prepare("INSERT INTO `customers`(`name_customer`, `email_customer`, `phone_customer`) VALUES (?, ?, ?)");
      $customers->execute([$name_customer, $email_customer, $phone_customer]);
      $customer_id = $con->lastInsertId();
      $_SESSION['customer_id'] = $customer_id;
      foreach ($_SESSION['cart'] as $cartItems => $item) {
        $product_name = $item['product_name'];
        $product_quantity = $item['quantity'];
        $product_price = $item['product_price'];
        $subtotal = $product_quantity * $product_price;
        $orders = $con->prepare("INSERT INTO `orders`(`orders_number`, `customer_id`, `product_name`, `product_quantity`, `product_price`, `subtotal`, `note_customer`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $orders->execute([$orders_number, $customer_id, $product_name, $product_quantity, $product_price, $subtotal, $note_customer]);
      }
    }
    unset($_SESSION['cart']);
    header('Location: cart.php?do=order-received');
    exit();
  } else {
    header('location: cart.php');
    exit();
  }
} elseif ($do == 'order-received') {
?>
  <div class="order-received">
    <div class="container">
      <h1>Thank you. Your order has been received.</h1>
      <?php if (isset($_SESSION['customer_id'])) {
        $stmt = $con->prepare("SELECT * FROM `customers` WHERE `id` = ?");
        $stmt->execute([$_SESSION['customer_id']]);
        $customer = $stmt->fetch();
        $order = $con->prepare("SELECT * FROM `orders` WHERE `customer_id` = ? ORDER BY `id` DESC");
        $order->execute([$customer['id']]);
        $orderCount = $order->rowCount();
        if ($orderCount > 0) {
      ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Order number</th>
                  <th>Date</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $order->fetch()) {
                  $orders_number = $row['orders_number'];
                  $order_date = date("F j, Y", strtotime($row['order_date']));
                  $total_price = $row['subtotal'];
                ?>
                  <tr>
                    <td>
                      <?php echo $orders_number ?>
                    </td>
                    <td>
                      <?php echo $order_date ?>
                    </td>
                    <td>
                      <?php echo number_format($total_price, 2) . '&nbsp;' . $row['currency']; ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="text-bg-light">
                <tr>
                  <th>Order details</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $order->execute([$customer['id']]);
                while ($row = $order->fetch()) {
                ?>
                  <tr>
                    <td>
                      <?php echo $row['product_name'] . ' x ' . $row['product_quantity'] ?>
                    </td>
                    <td>
                      <?php echo number_format($row['subtotal'], 2) . '&nbsp;' . $row['currency']; ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        <?php
        } else {
        ?>
          <div class="container">
            <div class="alert alert-warning text-center mt-5" role="alert">
              No orders found for this customer.
            </div>
          </div>
      <?php
        }
      } else {
        header('location: cart.php');
        exit();
      }
      ?>
    </div>
  </div>
<?php
} elseif ($do == 'add-cart') {
  if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $Details = $con->prepare("SELECT * FROM `products` WHERE `id` = ? LIMIT 1");
    $Details->execute([$id]);
    $cart = $Details->fetch(PDO::FETCH_ASSOC);
    $product_id = $cart['id'];
    $product_name = $cart['name_product'];
    $product_price = $cart['price_product'];
    $cart_item = array(
      'id' => $product_id,
      'product_name' => $product_name,
      'quantity' => $quantity,
      'product_price' => $product_price
    );
    $_SESSION['cart'][] = $cart_item;
    show_message($product_name . '&nbsp;added to cart successfully.', 'success');
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    header('location: index.php');
    exit();
  }
} elseif ($do == 'remove-product') {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $con->prepare("SELECT * FROM `products` WHERE `id` = ? LIMIT 1");
    $name->execute([$id]);
    $cart = $name->fetch(PDO::FETCH_ASSOC);
    $products = $cart['name_product'];
    foreach ($_SESSION['cart'] as $key => $item) {
      if ($item['id'] == $id) {
        unset($_SESSION['cart'][$key]);
        break;
      }
    }
    show_message($products . '&nbsp;removed from cart successfully.', 'success');
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    header('location: index.php');
    exit();
  }
} else {
}
include $tpl . 'footer.php';

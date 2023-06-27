<?php

function show_message($message, $type = 'success')
{
  if ($type == 'success') {
    $_SESSION['message'] = '<div class="alert alert-success">' . $message . '</div>';
  } else {
    $_SESSION['message'] = '<div class="alert alert-danger">' . $message . '</div>';
  }
}

function userInfo($con, $id)
{
  $stmt = $con->prepare("SELECT `id`, `username`, `password`, `fullname`, `email`, `biographical`, `phone`, `created` FROM `admin` WHERE `id` = ? LIMIT 1");
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function generateOrderNumber($con)
{
  $orderNumber = '#' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
  $query = $con->prepare("SELECT COUNT(*) FROM orders WHERE orders_number = ?");
  $query->execute([$orderNumber]);
  $count = $query->fetchColumn();
  if ($count > 0) {
    return generateOrderNumber($con);
  }
  return $orderNumber;
}

function getTitle()
{
  global $pageTitle;
  if (isset($pageTitle)) {
    echo $pageTitle;
  } else {
    echo 'Default';
  }
}

function checkImageDimensions($file_tmp)
{
  list($width, $height) = getimagesize($file_tmp);
  return $width === $height;
}

function productInfo($con, $id)
{
  $stmt = $con->prepare("SELECT `id`, `name_product`, `description_product`, `price_product`, `currency`, `img_product`, `stock_product`, `created_at` FROM `products` WHERE `id` = ? LIMIT 1");
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function ordersInfoView($con, $id)
{
  $stmt = $con->prepare("SELECT `orders`.`id`, `orders`.`orders_number`, `orders`.`customer_id`, `orders`.`product_name`, `orders`.`product_quantity`, `orders`.`product_price`, `orders`.`subtotal`, `orders`.`note_customer`, `orders`.`order_date`, `orders`.`order_status`, `customers`.`name_customer`, `customers`.`email_customer`, `customers`.`phone_customer` FROM `orders` INNER JOIN `customers` ON `orders`.`customer_id` = `customers`.`id` WHERE `orders`.`id` = ? LIMIT 1");
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function getProductById($product_id)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `products` WHERE id = :product_id");
  $stmt->execute(['product_id' => $product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  return $product;
}

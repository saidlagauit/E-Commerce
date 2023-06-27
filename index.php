<?php
session_start();
$pageTitle = 'Shop';
include './init.php';
$stmt = $con->prepare("SELECT `id`, `name_product`, `description_product`, `price_product`, `currency`, `img_product`, `stock_product`, `created_at` FROM `products`");
$stmt->execute();
$ListProducts = $stmt->fetchAll();
?>
<div class="product-list my-3">
  <div class="container">
    <h1>Last Products</h1>
    <div class="row g-3">
      <?php foreach ($ListProducts as $product) : ?>
        <div class="col-md-3">
          <div class="card">
            <img class="card-img-top" src="<?php echo $dirs . $product['img_product'] ?>" alt="<?php echo $product['name_product'] ?>">
            <div class="card-body">
              <a href="product.php?id=<?php echo $product['id'] ?>">
                <h5 class="card-title"><?php echo $product['name_product'] ?></h5>
              </a>
              <p class="card-text"><?php echo $product['price_product'] . ' ' . $product['currency'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include $tpl . 'footer.php';

<?php
session_start();
$pageTitle = 'Product';
include './init.php';
if (isset($_SESSION['username'])) {
  $do = isset($_GET['do']) ? $_GET['do'] : 'dashboard';
  if ($do == 'dashboard') {
    $ListProducts = $con->prepare("SELECT * FROM `products` ORDER BY `products`.`created_at` DESC");
    $ListProducts->execute();
    $products = $ListProducts->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="products">
      <div class="container">
        <h1>Products&nbsp;<a class="btn btn-outline-primary" href="./edit-products.php?do=add-new">Add New</a></h1>
        <div class="table-responsive">
          <?php if (isset($_SESSION['message'])) : ?>
            <div id="message">
              <?php echo $_SESSION['message']; ?>
            </div>
          <?php unset($_SESSION['message']);
          endif; ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Date</th>
                <th>Controller</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) : ?>
                <tr>
                  <td>
                    <img class="img-avatar-product rounded-circle" src="../uploads/<?php echo $product['img_product']; ?>" alt="<?php echo $product['name_product']; ?>">
                    <?php echo $product['name_product']; ?>
                  </td>
                  <td><?php echo $product['price_product'] . $product['currency']; ?></td>
                  <td><?php echo $product['stock_product']; ?></td>
                  <td><?php echo $product['created_at']; ?></td>
                  <td>
                    <form action="./edit-products.php?do=action" method="post">
                      <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                      <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-success" name="btn_edit"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
                        <a href="../product.php?id=<?php echo $product['id']; ?>" target="_blank" class="btn btn-info"><i class="fa-solid fa-eye"></i>&nbsp;View</a>
                        <button type="submit" class="btn btn-danger" name="btn_delete"><i class="fa-solid fa-trash"></i>&nbsp;Delete</button>
                      </div>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php
  } elseif ($do == 'add-new') {
  ?>
    <div class="add-new">
      <div class="container">
        <a class="btn btn-light my-2" href="./edit-products.php"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>
        <div class="col-md-6 mx-auto">
          <h1>Add new product</h1>
          <form action="./edit-products.php?do=create-true" method="post" class="py-3" enctype="multipart/form-data">
            <?php if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif; ?>
            <div class="form-group mb-3">
              <span class="label">Name</span>
              <input class="form-control" name="name_product" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Price</span>
              <input class="form-control" name="price_product" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Description</span>
              <textarea name="description_product" class="form-control" rows="3" required="required"></textarea>
            </div>
            <div class="form-group mb-3">
              <span class="label">Stock</span>
              <input class="form-control" type="number" name="stock_product" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Image</span>
              <input class="form-control" type="file" name="img_product" required="required" />
            </div>
            <button type="submit" class="btn btn-primary" name="create_true">
              Publish
            </button>
          </form>
        </div>
      </div>
    </div>
    <?php
  } elseif ($do == 'create-true') {
    if (isset($_POST['create_true'])) {
      $name_product = $_POST['name_product'];
      $description_product = $_POST['description_product'];
      $price_product = $_POST['price_product'];
      $stock_product = $_POST['stock_product'];
      if (!empty($_FILES['img_product']['name'])) {
        $upload_dir = '../uploads/';
        $file_ext = pathinfo($_FILES['img_product']['name'], PATHINFO_EXTENSION);
        $img_product = uniqid() . '.' . $file_ext;
        $img_product_path = $upload_dir . $img_product;
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($file_ext), $allowed_types)) {
          show_message('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        $max_file_size = 5 * 1024 * 1024; // 5MB
        if ($_FILES['img_product']['size'] > $max_file_size) {
          show_message('File size exceeds the allowed limit (5MB).', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        if (!checkImageDimensions($img_product_path)) {
          show_message('Invalid image dimensions.', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        if (!move_uploaded_file($_FILES['img_product']['tmp_name'], $img_product_path)) {
          show_message('Failed to upload image!', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        $stmt = $con->prepare("INSERT INTO `products`(`name_product`, `description_product`, `price_product`, `img_product`, `stock_product`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name_product, $description_product, $price_product, $img_product, $stock_product]);
        show_message('Product added successfully', 'success');
        header('location: edit-products.php');
        exit();
      } else {
        show_message('No image selected!', 'danger');
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
      }
    } else {
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } elseif ($do == 'action') {
    if (isset($_POST['btn_edit'])) {
      $id = $_POST['id'];
      $edit = productInfo($con, $id);
    ?>
      <div class="add-new">
        <div class="container">
          <a class="btn btn-light my-2" href="./edit-products.php"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>
          <div class="row">
            <div class="col-md-4">
              <img class="img-fluid" src="../uploads/<?php echo $edit['img_product']; ?>" alt="<?php echo $edit['name_product']; ?>">
            </div>
            <div class="col-md-8">
              <h1>Edit product : <?php echo $edit['name_product']; ?></h1>
              <form action="./edit-products.php?do=update-true" method="post" class="py-3" enctype="multipart/form-data">
                <?php if (isset($_SESSION['message'])) : ?>
                  <div id="message">
                    <?php echo $_SESSION['message']; ?>
                  </div>
                <?php unset($_SESSION['message']);
                endif; ?>
                <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                <div class="form-group mb-3">
                  <span class="label">Name</span>
                  <input class="form-control" name="name_product" value="<?php echo $edit['name_product']; ?>" required="required" />
                </div>
                <div class="form-group mb-3">
                  <span class="label">Price</span>
                  <input class="form-control" name="price_product" value="<?php echo $edit['price_product']; ?>" required="required" />
                </div>
                <div class="form-group mb-3">
                  <span class="label">Description</span>
                  <textarea name="description_product" class="form-control" rows="9" required="required"><?php echo $edit['description_product']; ?></textarea>
                </div>
                <div class="form-group mb-3">
                  <span class="label">Stock</span>
                  <input class="form-control" type="number" name="stock_product" value="<?php echo $edit['stock_product']; ?>" required="required" />
                </div>
                <div class="form-group mb-3">
                  <span class="label">Image</span>
                  <input class="form-control" type="file" name="img_product" />
                </div>
                <button type="submit" class="btn btn-primary" name="updated">
                  Update
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
<?php
    } elseif (isset($_POST['btn_delete'])) {
      $id = $_POST['id'];
      $stmt = $con->prepare("DELETE FROM products WHERE `products`.`id` = ?");
      $stmt->execute([$id]);
      show_message('Product delete successfully', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      header('location: edit-products.php');
      exit();
    }
  } elseif ($do == 'update-true') {
    if (isset($_POST['updated'])) {
      $id = $_POST['id'];
      $name_product = $_POST['name_product'];
      $description_product = $_POST['description_product'];
      $price_product = $_POST['price_product'];
      $stock_product = $_POST['stock_product'];
      if (!empty($_FILES['img_product']['name'])) {
        $upload_dir = '../uploads/';
        $file_ext = pathinfo($_FILES['img_product']['name'], PATHINFO_EXTENSION);
        $img_product = uniqid() . '.' . $file_ext;
        $img_product_path = $upload_dir . $img_product;
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($file_ext), $allowed_types)) {
          show_message('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        $max_file_size = 5 * 1024 * 1024; // 5MB
        if ($_FILES['img_product']['size'] > $max_file_size) {
          show_message('File size exceeds the allowed limit (5MB).', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        if (!checkImageDimensions($img_product_path)) {
          show_message('Invalid image dimensions.', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        if (!move_uploaded_file($_FILES['img_product']['tmp_name'], $img_product_path)) {
          show_message('Failed to upload image!', 'danger');
          header('location: ' . $_SERVER['HTTP_REFERER']);
          exit();
        }
        $stmt = $con->prepare("UPDATE `products` SET `name_product`= ?,`description_product`= ?,`price_product`= ?,`img_product`= ?,`stock_product`= ? WHERE `id`= ?");
        $stmt->execute([$name_product, $description_product, $price_product, $img_product, $stock_product, $id]);
      } else {
        $stmt = $con->prepare("UPDATE `products` SET `name_product`= ?,`description_product`= ?,`price_product`= ?,`stock_product`= ? WHERE `id`= ?");
        $stmt->execute([$name_product, $description_product, $price_product, $stock_product, $id]);
      }
      show_message('Product Update successfully', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } else {
    // Handle other cases
  }
} else {
  header('location: index.php');
  exit();
}

include $tpl . 'footer.php';

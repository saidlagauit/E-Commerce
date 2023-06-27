<?php
session_start();
$pageTitle = 'Customers';
include './init.php';
if (isset($_SESSION['username'])) {
  $do = isset($_GET['do']) ? $_GET['do'] : 'dashboard';
  $ListCustomer = $con->prepare("SELECT * FROM `customers` ORDER BY `customers`.`date_at` DESC");
  $ListCustomer->execute();
  $customers = $ListCustomer->fetchAll(PDO::FETCH_ASSOC);
  if ($do == 'dashboard') {
?>
    <div class="customers">
      <div class="container">
        <h1 class="">Customers&nbsp;<a class="btn btn-outline-primary" href="./edit-customers.php?do=new-customers">Add New</a></h1>
        <div class="table-responsive">
          <?php if (isset($_SESSION['message'])) : ?>
            <div id="message">
              <?php echo $_SESSION['message']; ?>
            </div>
          <?php unset($_SESSION['message']);
          endif; ?>
          <table class="table table-bordered">
            <thead>
              <tr class="text-bg-light">
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $customer) : ?>
                <tr>
                  <td><?php echo $customer['name_customer']; ?></td>
                  <td><?php echo $customer['email_customer']; ?></td>
                  <td><?php echo $customer['phone_customer']; ?></td>
                  <td><?php echo $customer['date_at']; ?></td>
                  <td>
                    <form action="./edit-customers.php?do=action" method="post">
                      <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                      <input type="hidden" name="name_customer" value="<?php echo $customer['name_customer']; ?>">
                      <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-success" name="btn_edit"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</button>
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
  } elseif ($do == 'action') {
    if (isset($_POST['btn_edit'])) {
      $id = $_POST['id'];
      $edit = $con->prepare("SELECT `id`, `name_customer`, `email_customer`, `phone_customer`, `date_at` FROM `customers` WHERE `id` = ? LIMIT 1");
      $edit->execute([$id]);
      $row = $edit->fetch();
      $count = $edit->rowCount();
      if ($count > 0) {
    ?>
        <div class="edit-customer">
          <div class="container">
            <a class="btn btn-light my-2" href="./edit-customers.php"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>
            <div class="col-md-6 mx-auto">
              <h1>Edit Customer : <?php echo $row['name_customer']; ?></h1>
              <form action="./edit-customers.php?do=update-true" method="post">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                  <label for="name_customer">Full Name *</label>
                  <input type="text" name="name_customer" id="name_customer" value="<?php echo $row['name_customer']; ?>" class="form-control" required="required">
                </div>
                <div class="form-group">
                  <label for="phone_customer">Phone *</label>
                  <input type="tel" name="phone_customer" id="phone_customer" value="<?php echo $row['phone_customer']; ?>" class="form-control" required="required">
                </div>
                <div class="form-group">
                  <label for="email_customer">Email Address *</label>
                  <input type="email" name="email_customer" id="email_customer" value="<?php echo $row['email_customer']; ?>" class="form-control" required="required">
                </div>
                <button type="submit" class="btn btn-primary my-3" name="customer_update">Update</button>
              </form>
            </div>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="container">
          <div class="alert alert-warning text-center mt-5" role="alert">
            Theres no such customers
          </div>
        </div>
    <?php
        header('Refresh: 6; url=./edit-customers.php');
      }
    } elseif (isset($_POST['btn_delete'])) {
      $id = $_POST['id'];
      $name_customer = $_POST['name_customer'];
      $stmt = $con->prepare("DELETE FROM customers WHERE `customers`.`id` = ?");
      $stmt->execute([$id]);
      show_message('Customer ' . $name_customer . ' deleted successfully', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } elseif ($do == 'new-customers') {
    ?>
    <div class="new-customer">
      <div class="container">
        <a class="btn btn-light my-2" href="./edit-customers.php"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>
        <div class="col-md-6 mx-auto">
          <h1>New Customer</h1>
          <form action="./edit-customers.php?do=customer-true" method="post">
            <?php if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif; ?>
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
            <button type="submit" class="btn btn-primary my-3" name="customer_true">Saved</button>
          </form>
        </div>
      </div>
    </div>
<?php
  } elseif ($do == 'customer-true') {
    if (isset($_POST['customer_true'])) {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $name_customer = $_POST['name_customer'];
      $email_customer = $_POST['email_customer'];
      $phone_customer = $_POST['phone_customer'];
      $stmt = $con->prepare("INSERT INTO `customers`(`name_customer`, `email_customer`, `phone_customer`) VALUES (?,?,?)");
      $stmt->execute([$name_customer, $email_customer, $phone_customer]);
      show_message('Customer ' . $name_customer . ' added successfully', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } elseif ($do == 'update-true') {
    if (isset($_POST['customer_update'])) {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $id = $_POST['id'];
      $name_customer = $_POST['name_customer'];
      $email_customer = $_POST['email_customer'];
      $phone_customer = $_POST['phone_customer'];
      $stmt = $con->prepare("UPDATE `customers` SET `name_customer`= ?,`email_customer`= ?,`phone_customer`= ? WHERE `id`= ?");
      $stmt->execute([$name_customer, $email_customer, $phone_customer, $id]);
      show_message('Customer ' . $name_customer . ' updated successfully', 'success');
      header('location: edit-customers.php');
      exit();
    } else {
      header('location: edit-customers.php');
      exit();
    }
  }
} else {
  header('location: index.php');
  exit();
}
include $tpl . 'footer.php';

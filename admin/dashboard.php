<?php
session_start();
$pageTitle = 'Dashboard';
include './init.php';
if (isset($_SESSION['username'])) {
  $do = isset($_GET['do']) ? $_GET['do'] : 'dashboard';
  if ($do == 'dashboard') {

    $totalSubtotal = $con->query("SELECT SUM(subtotal) AS total_subtotal FROM orders WHERE order_status = 'completed'")->fetchColumn();
    $customersCount = $con->query("SELECT COUNT(*) AS total_customers FROM customers")->fetchColumn();

?>
    <div class="dashboard">
      <div class="container">
        <h1>Dashboard</h1>
        <div class="dashboard-status py-3">
          <div class="row">


            <div class="col-md-4">
              <div class="card border-secondary">
                <div class="card-body">
                  <h4 class="card-title">Total Sell</h4>
                  <p class="card-text"><?php echo $totalSubtotal; ?></p>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card border-secondary">
                <div class="card-body">
                  <h4 class="card-title">Costumers</h4>
                  <p class="card-text"><?php echo $customersCount ?></p>
                </div>
              </div>
            </div>



          </div>
        </div>
      </div>
    </div>
<?php
  } elseif ($do == '') {
  } elseif ($do == '') {
  } elseif ($do == '') {
  } elseif ($do == '') {
    # code...
  }
} else {
  header('location: index.php');
  exit();
}
include $tpl . 'footer.php';

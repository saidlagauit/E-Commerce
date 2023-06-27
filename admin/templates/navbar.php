<nav class="navbar navbar-expand-lg bg-body-tertiary text-capitalize">
  <div class="container">
    <a class="navbar-brand h1" href="./dashboard.php">Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar" aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="MyNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="edit-customers.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="edit-orders.php">Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="./edit-products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contacts</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="./edit-profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="../">Visit Store</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="./logout.php">LogOut</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';
include './init.php';
$do = isset($_GET['do']) ? $_GET['do'] : 'view';

if ($do == 'view') {
  if (isset($_COOKIE['login_credentials'])) {
    list($username, $password) = explode('|', $_COOKIE['login_credentials']);
    $username = htmlentities($username, ENT_QUOTES);
    $password = htmlentities($password, ENT_QUOTES);
    $rememberMeChecked = 'checked';
  } else {
    $username = '';
    $password = '';
    $rememberMeChecked = '';
  }
?>
  <div class="login py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <form action="index.php?do=enter-true" method="POST" autocomplete="off">
            <h1>Login - Said Lagauit | Store</h1>
            <?php
            if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif;
            ?>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" required="required">
              <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required="required">
              <label for="floatingPassword">Password</label>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary" name="enter" disabled>Enter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php
} elseif ($do == 'enter-true') {
  if (isset($_POST['enter'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPass = sha1($password);
    $stmt = $con->prepare("SELECT `id`, `username`, `password` FROM `admin` WHERE `username` = ? AND `password` = ?");
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
      $_SESSION['username'] = $username; // Register Session Name
      $_SESSION['id'] = $row['id']; // Register Session ID
      if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
        $cookieName = 'login_credentials';
        $cookieValue = $username . '|' . $password;
        $cookieExpire = time() + (86400 * 30); // 30 days
        setcookie($cookieName, $cookieValue, $cookieExpire, '/');
      }
      header('location: dashboard.php');
      exit();
    } else {
      show_message('Sorry, You must make sure that the information entered is correct', 'danger');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } else {
    header('location: index.php');
    exit();
  }
}

include $tpl . 'footer.php';

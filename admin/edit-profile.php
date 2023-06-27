<?php
session_start();
$pageTitle = 'Profile';
include './init.php';
if (isset($_SESSION['username'])) {
  $do = isset($_GET['do']) ? $_GET['do'] : 'view';
  if ($do == 'view') {
    $id = $_SESSION['id'];
    $profile = userInfo($con, $id);
?>
    <div class="profile">
      <div class="container">
        <div class="col-md-6 mx-auto">
          <h1>Profile</h1>
          <form action="./edit-profile.php?do=update" autocomplete="off" method="post" class="py-3" enctype="multipart/form-data">
            <?php if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif; ?>
            <input type="hidden" name="id" value="<?php echo $profile['id']; ?>">
            <div class="form-group mb-3">
              <span class="label">Username</span>
              <input class="form-control" name="username" value="<?php echo $profile['username']; ?>" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Full Name</span>
              <input class="form-control" name="fullname" value="<?php echo $profile['fullname']; ?>" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Email</span>
              <input class="form-control" name="email" value="<?php echo $profile['email']; ?>" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Biographical</span>
              <textarea name="biographical" class="form-control" rows="3" required="required"><?php echo $profile['biographical']; ?></textarea>
            </div>
            <div class="form-group mb-3">
              <span class="label">Phone</span>
              <input class="form-control" type="tel" name="phone" value="<?php echo $profile['phone']; ?>" required="required" />
            </div>
            <div class="form-group mb-3">
              <span class="label">Password</span>
              <input type="hidden" name="password-old" class="form-control" value="<?php echo $profile['password']; ?>" />
              <input type="password" name="password-new" class="form-control" placeholder="Leave blank if you don't want to make any changes" />
            </div>
            <button type="submit" class="btn btn-primary" name="update">
              Update Profile
            </button>
          </form>
        </div>
      </div>
    </div>
<?php
  } elseif ($do == 'update') {
    if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $username = $_POST['username'];
      $password = empty($_POST['password-new']) ? $_POST['password-old'] : sha1($_POST['password-new']);
      $fullname = $_POST['fullname'];
      $email = $_POST['email'];
      $biographical = $_POST['biographical'];
      $phone = $_POST['phone'];
      $stmt = $con->prepare("UPDATE `admin` SET `username`= ?,`password`= ?,`fullname`= ?,`email`= ?,`biographical`= ?,`phone`= ? WHERE `id`= ?");
      $stmt->execute(array($username, $password, $fullname, $email, $biographical, $phone, $id));
      show_message('The profile has been updated successfully', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } elseif ($do == '') {
  }
} else {
  header('location: index.php');
  exit();
}
include $tpl . 'footer.php';

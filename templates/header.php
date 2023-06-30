<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
  $selectedLanguage = $_POST['language'];
  $_SESSION['language'] = $selectedLanguage;
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}
if (isset($_SESSION['language'])) {
  $selectedLanguage = $_SESSION['language'];
} else {
  $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  $supportedLanguages = ['en', 'ar'];
  $selectedLanguage = in_array($browserLanguage, $supportedLanguages) ? $browserLanguage : 'en';
  $_SESSION['language'] = $selectedLanguage;
}
if ($selectedLanguage === 'ar') {
  include $lang . "ar.php";
} else {
  include $lang . "en.php";
}
?>
<!doctype html>
<html dir="<?php echo $lang['Ltr']; ?>" lang="<?php echo $lang['En']; ?>" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $lang['Said Lagauit'] . ' | ' . $lang[getTitle()] ?></title>
  <meta name="description" content="Discover a wide range of high-quality digital products at the Said Lagauit Online Store. Shop for software, applications, games, and more. Enjoy great deals, fast delivery, and exceptional customer service. Start your online shopping experience for digital products today!" />
  <link rel="shortcut icon" href="<?php echo $img ?>favicon_io/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo $css; ?><?php echo $lang['Bootstrap']; ?>" />
  <link rel="stylesheet" href="<?php echo $css ?>all.min.css" />
  <link rel="stylesheet" href="<?php echo $css ?>main.css" />

</head>

<body>
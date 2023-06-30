<?php
session_start();
$pageTitle = 'FAQ';
include './init.php';
?>
<div class="faq">
  <div class="container">
    <h1>Frequently Asked Questions</h1>
    <div class="col-md-10 mx-auto">
      <?php displayFAQ($faqItems); ?>
    </div>
  </div>
</div>
<?php
include $tpl . 'footer.php'; ?>
<?php
session_start();
$pageTitle = 'FAQ';
include './init.php';
?>
<div class="faq">
  <div class="container">
    <div class="col-md-6 mx-auto">
      <h1>Frequently Asked Questions</h1>
      <?php displayFAQ($faqItems); ?>
    </div>
  </div>
</div>
<?php
include $tpl . 'footer.php'; ?>
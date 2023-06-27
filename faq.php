<?php
session_start();
$pageTitle = 'FAQ';
include './init.php';
?>
<div class="faq">
  <div class="container">
    <h1>Frequently Asked Questions</h1>
    <?php displayFAQ($faqItems); ?> <!-- Call the function to display FAQ items -->
  </div>
</div>
<?php
include $tpl . 'footer.php'; ?>
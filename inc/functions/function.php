<?php
function show_message($message, $type = 'success')
{
  if ($type == 'success') {
    $_SESSION['message'] = '<div class="alert alert-success">' . $message . '</div>';
  } else {
    $_SESSION['message'] = '<div class="alert alert-danger">' . $message . '</div>';
  }
}
function userInfo($con, $id)
{
  $stmt = $con->prepare("SELECT `id`, `username`, `password`, `fullname`, `email`, `biographical`, `phone`, `created` FROM `admin` WHERE `id` = ? LIMIT 1");
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function generateOrderNumber($con)
{
  $orderNumber = '#' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
  $query = $con->prepare("SELECT COUNT(*) FROM orders WHERE orders_number = ?");
  $query->execute([$orderNumber]);
  $count = $query->fetchColumn();
  if ($count > 0) {
    return generateOrderNumber($con);
  }
  return $orderNumber;
}

function getTitle()
{
  global $pageTitle;
  if (isset($pageTitle)) {
    echo $pageTitle;
  } else {
    echo 'Default';
  }
}

function pageActive($currentPage, $pageName)
{
  if ($currentPage == $pageName) {
    echo 'active';
  } else {
    echo '';
  }
}

function displayFAQ($faqItems)
{
?>
  <div class="accordion" id="faqAccordion">
    <?php foreach ($faqItems as $index => $item) : ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeading<?php echo $index ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $index ?>" aria-expanded="false" aria-controls="faqCollapse<?php echo $index ?>">
            <?php echo $item['question'] ?>
          </button>
        </h2>
        <div id="faqCollapse<?php echo $index ?>" class="accordion-collapse collapse" aria-labelledby="faqHeading<?php echo $index ?>" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            <p><?php echo $item['answer'] ?></p>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
<?php
}

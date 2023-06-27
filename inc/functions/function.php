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
  echo '<div class="accordion" id="faqAccordion">';

  foreach ($faqItems as $index => $item) {
    echo '<div class="accordion-item">';
    echo '<h3 class="accordion-header" id="faqHeading' . $index . '">';
    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse' . $index . '" aria-expanded="false" aria-controls="faqCollapse' . $index . '">';
    echo $item['question'];
    echo '</button>';
    echo '</h3>';
    echo '<div id="faqCollapse' . $index . '" class="accordion-collapse collapse" aria-labelledby="faqHeading' . $index . '" data-bs-parent="#faqAccordion">';
    echo '<div class="accordion-body">';
    echo '<p>' . $item['answer'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  echo '</div>';
}

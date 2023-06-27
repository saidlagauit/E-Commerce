<?php

include './connect.php';

$func = './inc/functions/';
$lang = './inc/languages/';
$arr = './inc/arrays/';
$tpl = './templates/';
$dirs = './uploads/';

$css = './assets/css/';
$img = './assets/img/';
$js = './assets/js/';

include_once $func . 'function.php';
include_once $arr . 'arrays.php';
include_once $lang . 'en.php';

include_once $tpl . 'header.php';
include_once $tpl . 'navbar.php';

?>
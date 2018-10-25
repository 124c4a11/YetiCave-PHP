<?php


require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';


session_start();


$promo_list = include_template('templates/blocks/promo-list.php', ['categories' => $categories]);
$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($connect) {
  $sql = 'SELECT l.id, l.name, end_date, image, start_price, c.name category FROM lots l
          JOIN categories c ON c.id = l.category_id
          WHERE end_date >= CURDATE()
          ORDER BY end_date DESC';
  $res = mysqli_query($connect, $sql);

  if ($res) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $page_content = include_template('./templates/index.php', ['lots' => $lots, 'promo_list' => $promo_list]);
  }
} else {
  $page_content = include_template('./templates/index.php', ['promo_list' => $promo_list]);
}


$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - Главная',
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print($layout_content);
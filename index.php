<?php


require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';


session_start();


if ($connect) {
  $sql = 'SELECT l.id, l.name, end_date, image, start_price, c.name category FROM lots l
          JOIN categories c ON c.id = l.category_id
          WHERE end_date >= CURDATE()
          ORDER BY end_date DESC';
  $res = mysqli_query($connect, $sql);

  if ($res) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $page_content = include_template('./templates/index.php', ['lots' => $lots]);
  }
} else {
  $page_content = include_template('./templates/index.php', []);
}


$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - Главная',
  'content' => $page_content,
  'categories' => $categories
]);


print($layout_content);
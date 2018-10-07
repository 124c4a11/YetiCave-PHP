<?php


require_once('config.php');
require_once('functions.php');
require_once('data.php');


session_start();


$lot = null;


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $popular_lots = [];
  $expire = strtotime('+1 day');

  foreach ($lots as $item) {
    if ($item['id'] == $id) {
      $lot = $item;
      break;
    }
  }

  // cookie
  if (isset($_COOKIE['popular_lots'])) {
    $popular_lots = json_decode($_COOKIE['popular_lots'], true);

    if (!in_array($id, $popular_lots)) {
      $popular_lots[] = $id;
      $popular_lots = json_encode($popular_lots);
      setcookie('popular_lots', $popular_lots, $expire, '/');
    }
  } else {
    $popular_lots[] = $id;
    $popular_lots = json_encode($popular_lots);
    setcookie('popular_lots', $popular_lots, $expire, '/');
  }
}


if (!$lot) http_response_code(404);


$page_content = include_template('./templates/lot.php', ['lot' => $lot]);
$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . ($lot['title'] ?? 'Лот не сеществует!'),
  'content' => $page_content,
  'categories' => $categories
]);


print($layout_content);
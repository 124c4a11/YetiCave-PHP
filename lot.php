<?php


require_once('config.php');
require_once('functions.php');
require_once('data.php');


$lot = null;


if (isset($_GET['id'])) {
  $lot_id = $_GET['id'];

  foreach ($lots as $item) {
    if ($item['id'] == $lot_id) {
      $lot = $item;
      break;
    }
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
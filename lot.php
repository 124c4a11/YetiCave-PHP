<?php

require_once('config.php');
require_once('functions.php');
require_once('data.php');


$lot = null;


if (isset($_GET['lot_id'])) {
  $lot_id = $_GET['lot_id'];

  foreach ($lots as $lot_item) {
    if ($lot_item['id'] == $lot_id) {
      $lot = $lot_item;
      break;
    }
  }
}

if (!$lot) {
  http_response_code(404);
}


$page_content = include_template('templates/lot.php', ['lot' => $lot]);
$layout_content = include_template('templates/layout.php', [
  'pagetitle' => 'YetiCave - ' . ($lot['title'] ?? 'Лот не сеществует!'),
  'content' => $page_content,
  'categories' => $categories
]);


print($layout_content);
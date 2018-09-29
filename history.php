<?php


require_once('data.php');
require_once('functions.php');


$popular_lots_data = [];


if ($_COOKIE['popular_lots']) {
  $popular_lots = json_decode($_COOKIE['popular_lots'], true);

  foreach($lots as $lot) {
    if (in_array($lot['id'], $popular_lots)) {
      $popular_lots_data[] = $lot;
    }
  }
}


$page_content = include_template('./templates/history.php', ['lots' => $popular_lots_data]);
$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => 'История просмотров',
  'content' => $page_content
]);


print($layout_content);
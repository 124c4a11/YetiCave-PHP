<?php


require_once 'data.php';
require_once 'functions.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);
$popular_lots_data = [];


if ($_COOKIE['popular_lots']) {
  $popular_lots = json_decode($_COOKIE['popular_lots'], true);

  foreach($lots as $lot) {
    if (in_array($lot['id'], $popular_lots)) {
      $popular_lots_data[] = $lot;
    }
  }
}


$page_content = include_template('./templates/history.php', ['lots' => $popular_lots_data, 'nav_list' => $nav_list]);
$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => 'История просмотров',
  'nav_list' => $nav_list,
  'content' => $page_content
]);


print($layout_content);
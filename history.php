<?php


require_once 'init.php';
require_once 'data.php';
require_once 'functions.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);
$popular_lots_data = [];


if ($_COOKIE['popular_lots']) {
  $popular_lots_ids_str = join(', ', json_decode($_COOKIE['popular_lots'], true));

  // pagination data
  $cur_page = $_GET['page'] ?? 1;
  $href = 'history.php?page=';
  $limit = 6;
  $offset = ($cur_page - 1) * $limit;

  $sql = 'SELECT COUNT(*) AS cnt FROM lots WHERE id IN (' . $popular_lots_ids_str . ')';
  $res = mysqli_query($connect, $sql);
  $items_count = mysqli_fetch_assoc($res)['cnt'];
  $pages_count = ceil($items_count / $limit);
  $pages = range(1, $pages_count);

  $popular_lots = get_lots_by_ids_str($connect, $popular_lots_ids_str, $limit, $offset);

  $lots_list = include_template('./templates/blocks/lots-list.php', ['lots' => $popular_lots]);
  $pagination = include_template('./templates/blocks/pagination.php', [
    'href' => $href,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count,
    'pages' => $pages
  ]);
}




$page_content = include_template('./templates/all-lots.php', [
  'pagetitle' => 'История просмотров',
  'nav_list' => $nav_list,
  'lots_list' => $lots_list,
  'pagination' => $pagination
]);

$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => 'История просмотров',
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print($layout_content);
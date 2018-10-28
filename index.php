<?php


require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';


session_start();


$promo_list = include_template('templates/blocks/promo-list.php', ['categories' => $categories]);
$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($connect) {
  // pagination data
  $cur_page = $_GET['page'] ?? 1;
  $href = '/?page=';
  $limit = 6;
  $offset = ($cur_page - 1) * $limit;

  $sql = 'SELECT COUNT(*) AS cnt FROM lots WHERE end_date >= CURDATE()';
  $res = mysqli_query($connect, $sql);
  $items_count = mysqli_fetch_assoc($res)['cnt'];
  $pages_count = ceil($items_count / $limit);
  $pages = range(1, $pages_count);
  
  $lots = get_last_lots($connect, $limit, $offset);

  if ($lots && count($lots)) {
    $lots_list = include_template('./templates/blocks/lots-list.php', ['lots' => $lots]);

    $pagination = include_template('./templates/blocks/pagination.php', [
      'href' => $href,
      'cur_page' => $cur_page,
      'pages_count' => $pages_count,
      'pages' => $pages
    ]);

    $page_content = include_template('./templates/index.php', [
      'promo_list' => $promo_list,
      'lots_list' => $lots_list,
      'pagination' => $pagination
    ]);
  } else {
    $page_content = include_template('./templates/index.php', ['promo_list' => $promo_list]);
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
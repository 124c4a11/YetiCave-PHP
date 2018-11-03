<?php


require_once 'init.php';
require_once 'data.php';
require_once 'functions.php';


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($_GET['id'] && isset($_GET['id'])) {
  $category_id = $_GET['id'];
  $category_name = get_category_by_id($connect, $category_id)['name'];

  // pagination data
  $cur_page = $_GET['page'] ?? 1;
  $href = 'category.php?id=' . $category_id . '&page=';
  $limit = 6;
  $offset = ($cur_page - 1) * $limit;

  $sql = 'SELECT COUNT(*) AS cnt FROM lots WHERE category_id = ' . $category_id;
  $res = mysqli_query($connect, $sql);
  $items_count = mysqli_fetch_assoc($res)['cnt'];
  $pages_count = ceil($items_count / $limit);
  $pages = range(1, $pages_count);

  $lots = get_lots_by_category_id($connect, $category_id, $limit, $offset);

  if ($lots && count($lots)) {
    $lots_list = include_template('./templates/blocks/lots-list.php', ['lots' => $lots]);

    $pagination = include_template('./templates/blocks/pagination.php', [
      'href' => $href,
      'cur_page' => $cur_page,
      'pages_count' => $pages_count,
      'pages' => $pages
    ]);

    $page_content = include_template('./templates/all-lots.php', [
      'pagetitle' => $category_name,
      'nav_list' => $nav_list,
      'lots_list' => $lots_list,
      'pagination' => $pagination
    ]);
  } else {
    $page_content = include_template('./templates/all-lots.php', [
      'pagetitle' => 'Лоты данной категории не найдены',
      'nav_list' => $nav_list
    ]);
  }
} else {
  $page_content = include_template('./templates/all-lots.php', ['nav_list' => $nav_list]);
}


$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $category_name,
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print $layout_content;
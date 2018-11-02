<?php


require_once 'init.php';
require_once 'functions.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($_GET['search'] && isset($_GET['search'])) {
  $query = $_GET['search'];

  mysqli_query($connect, 'CREATE FULLTEXT INDEX lot_ft_search ON lots(name, description)');

  // pagination data
  $cur_page = $_GET['page'] ?? 1;
  $href = 'search.php?search=' . $query . '&find=Найти' . '&page=';
  $limit = 6;
  $offset = ($cur_page - 1) * $limit;

  $sql = 'SELECT COUNT(*) AS cnt FROM lots WHERE MATCH(name, description) AGAINST(?)';
  $stmt = db_get_prepare_stmt($connect, $sql, [$query]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);
  $items_count = mysqli_fetch_assoc($res)['cnt'];
  $pages_count = ceil($items_count / $limit);
  $pages = range(1, $pages_count);

  $lots = get_lots_by_search_query($connect, $query, $limit, $offset);

  if ($lots && count($lots)) {
    $lots_list = include_template('templates/blocks/lots-list.php', ['lots' => $lots]);

    $pagination = include_template('./templates/blocks/pagination.php', [
      'href' => $href,
      'cur_page' => $cur_page,
      'pages_count' => $pages_count,
      'pages' => $pages
    ]);

    $page_content = include_template('templates/all-lots.php', [
      'pagetitle' => 'Результат поиска по запросу "' . $query . '"',
      'lots_list' => $lots_list,
      'pagination' => $pagination
    ]);
  }
} else {
  $page_content = include_template('templates/all-lots.php', ['pagetitle' => 'Введите запрос для поиска']);
}


$layout_content = include_template('templates/layout.php', [
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print($layout_content);
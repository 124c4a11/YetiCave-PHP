<?php


require_once 'init.php';
require_once 'functions.php';


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($_GET['search'] && isset($_GET['search'])) {
  $query = $_GET['search'];

  mysqli_query($connect, 'CREATE FULLTEXT INDEX lot_ft_search ON lots(name, description)');

  $sql = 'SELECT l.*, u.name author, c.name category FROM lots l
          LEFT JOIN categories c ON c.id = l.category_id
          LEFT JOIN users u ON u.id = l.author_id
          WHERE MATCH(l.name, l.description) AGAINST(?)';
  $stmt = db_get_prepare_stmt($connect, $sql, [$query]);
  
  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);
  $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);

  if ($lots && count($lots)) {
    $lots_list = include_template('templates/blocks/lots-list.php', ['lots' => $lots]);
    $page_content = include_template('templates/all-lots.php', [
      'pagetitle' => 'Результат поиска по запросу "' . $query . '"',
      'lots_list' => $lots_list
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
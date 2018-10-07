<?php


require_once('config.php');
require_once('functions.php');
require_once('data.php');


session_start();


$page_content = include_template('./templates/index.php', ['lots' => $lots]);
$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - Главная',
  'content' => $page_content,
  'categories' => $categories
]);


print($layout_content);
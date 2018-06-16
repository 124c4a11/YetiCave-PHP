<?php

require_once('config.php');
require_once('data.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot = $_POST;

  if (isset($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_name, 'img/' . $image);
  }

  if ($image) {
    $lot['image'] = $image;
  }

  $page_content = include_template('templates/lot.php', ['lot' => $lot]);
} else {
  $page_content = include_template('templates/add-lot.php', []);
}


$layout_content = include_template('templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . 'Добавить лот',
  'categories' => $categories,
  'content' => $page_content
]);


print($layout_content);
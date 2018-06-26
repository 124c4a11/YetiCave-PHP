<?php

require_once('config.php');
require_once('data.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot = $_POST;
  $requireds = ['name', 'category', 'description', 'rate', 'step', 'date'];
  $errors = [];

  foreach ($lot as $key => $value) {
    if (in_array($key, $requireds)) {
      if (!$value) {
        $errors[$key] = 'Заполните это поле';
      }

      if ($key == 'category' && $value == 'Выберите категорию') {
        $errors[$key] = 'Выберите категорию';
      }
    }
  }

  if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '') {
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);

    if ($file_type == 'image/jpeg' || $file_type == 'image/png') {
      $lot['image'] = $image;
      move_uploaded_file($tmp_name, 'img/' . $image);
    } else {
      $errors['image'] = 'Загрузите изображение в формате JPG или PNG';
    }
  } else {
    $errors['image'] = 'Выберите изображение';
  }

  if (!is_numeric($lot['rate']) || $lot['rate'] <= 0) {
    $errors['rate'] = 'Число должно быть больше нуля';
  }

  if (!is_numeric($lot['step']) || $lot['step'] <= 0) {
    $errors['step'] = 'Число должно быть больше нуля';
  }

  if (count($errors)) {
    $page_content = include_template('templates/add-lot.php', ['lot'=> $lot, 'errors' => $errors, 'categories' => $categories]);
  } else {
    $page_content = include_template('templates/lot.php', ['lot' => $lot]);
  }
} else {
  $page_content = include_template('templates/add-lot.php', ['categories' => $categories]);
}


$layout_content = include_template('templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . 'Добавить лот',
  'categories' => $categories,
  'content' => $page_content
]);


print($layout_content);
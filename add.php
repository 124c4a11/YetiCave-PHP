<?php


require_once 'init.php';
require_once 'config.php';
require_once 'data.php';
require_once 'functions.php';


session_start();


if (!isset($_SESSION['user'])) http_response_code('403');


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
      $lot['image'] = 'img/' . $image;
      move_uploaded_file($tmp_name, 'img/' . $image);
    } else {
      $errors['image'] = 'Загрузите изображение в формате JPG или PNG';
    }
  } else {
    $errors['image'] = 'Выберите изображение';
  }

  if (!is_numeric($lot['price']) || $lot['price'] <= 0) {
    $errors['price'] = 'Число должно быть больше нуля';
  }

  if (!is_numeric($lot['step']) || $lot['step'] <= 0) {
    $errors['step'] = 'Число должно быть больше нуля';
  }

  if (count($errors)) {
    $page_content = include_template('./templates/add-lot.php', ['lot'=> $lot, 'errors' => $errors, 'categories' => $categories]);
  } else {
    $author_id = $_SESSION['user']['id'];
    $category_id = get_category_id_by_name($connect, $lot['category']);
    $sql = 'INSERT INTO lots (name, image, description, start_price, step, end_date, author_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql, [$lot['name'], $lot['image'], $lot['description'], $lot['price'], $lot['step'], $lot['date'], $author_id, $category_id]);
    mysqli_stmt_execute($stmt);

    // $page_content = include_template('./templates/lot.php', ['lot' => $lot]);
  }
} else {
  $page_content = include_template('./templates/add-lot.php', ['categories' => $categories]);
}


$layout_content = include_template('templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . 'Добавить лот',
  'categories' => $categories,
  'content' => $page_content
]);


print($layout_content);
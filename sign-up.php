<?php


require_once('data.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = $_POST;
  $requireds = ['email', 'password', 'name', 'contacts'];
  $errors = [];

  foreach($user as $key => $val) {
    if (in_array($key, $requireds) && !$val) {
      if ($key == 'email') $errors[$key] = 'Введите e-mail';
      if ($key == 'password') $errors[$key] = 'Введите пароль';
      if ($key == 'name') $errors[$key] = 'Введите имя';
      if ($key == 'contacts') $errors[$key] = 'Напишите как с Вами связаться';
    }
  }

  if ($user['email'] != '' && !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный e-mail';
  }

  if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name'] != '') {
    $image_name = $_FILES['avatar']['name'];
    $tmp_name = $_FILES['avatar']['tmp_name'];
    $file_type = mime_content_type($tmp_name);

    if ($file_type == 'image/jpeg' || $file_type == 'image/png') {
      move_uploaded_file($tmp_name, 'uploads/' . $image_name);
      $user['avatar'] = 'uploads/' . $image_name;
    } else {
      $errors['avatar'] = 'Загружаемый файл должен быть в одном из форматов: jpeg, jpg, png';
    } 
  }

  if (count($errors)) {
    $page_content = include_template('templates/sign-up.php', ['user' => $user, 'errors' => $errors]);
  } else {
    $page_content = include_template('templates/sign-up.php', ['user' => $user]);
  }
} else {
  $page_content = include_template('templates/sign-up.php', []);
}


$layout_content = include_template('templates/layout.php', [
  'pagetitle' => 'Регистрация аккаунта',
  'categories' => $categories,
  'content' => $page_content
]);


print($layout_content);
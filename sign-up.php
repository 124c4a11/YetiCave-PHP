<?php


require_once 'init.php';
require_once 'data.php';
require_once 'functions.php';
require_once 'mysql_helper.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $form = $_POST;
  $requireds = ['email', 'password', 'name', 'contacts'];
  $errors = [];

  foreach($form as $key => $val) {
    if (in_array($key, $requireds) && !$val) {
      if ($key == 'email') $errors[$key] = 'Введите e-mail';
      if ($key == 'password') $errors[$key] = 'Введите пароль';
      if ($key == 'name') $errors[$key] = 'Введите имя';
      if ($key == 'contacts') $errors[$key] = 'Напишите как с Вами связаться';
    }
  }

  if ($form['email'] && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный e-mail';
  }

  if ($connect && !isset($errors['email'])) {
    $user = get_user_by_email($connect, $form['email']);
    if ($user && count($user)) $errors['email'] = 'Этот e-mail занят';
  }

  if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name'] != '') {
    $image_name = $_FILES['avatar']['name'];
    $tmp_name = $_FILES['avatar']['tmp_name'];
    $file_type = mime_content_type($tmp_name);

    if ($file_type == 'image/jpeg' || $file_type == 'image/png') {
      move_uploaded_file($tmp_name, 'uploads/' . $image_name);
      $form['avatar'] = 'uploads/' . $image_name;
    } else {
      $errors['avatar'] = 'Загружаемый файл должен быть в одном из форматов: jpeg, jpg, png';
    } 
  }

  if (count($errors)) {
    $page_content = include_template('templates/sign-up.php', ['user' => $form, 'errors' => $errors]);
  } else {
    if ($connect) {
      $pas = password_hash($form['password'], PASSWORD_DEFAULT);
      $avatar = $form['avatar'] ?? '';
      $sql = "INSERT INTO users (name, email, password, contacts, avatar) VALUES (?, ?, ?, ?, ?)";
      $stmt = db_get_prepare_stmt($connect, $sql, [$form['name'], $form['email'], $pas, $form['contacts'], $avatar]);
      $res = mysqli_stmt_execute($stmt);

      if ($res) {
        $_SESSION['new_user']['email'] = $form['email'];
        $_SESSION['new_user']['password'] = $form['password'];

        header('Location: login.php');
        exit();
      }
    }

    $page_content = include_template('templates/sign-up.php', ['user' => $form, 'nav_list' => $nav_list]);
  }
} else {
  $page_content = include_template('templates/sign-up.php', ['nav_list' => $nav_list]);
}


$layout_content = include_template('templates/layout.php', [
  'pagetitle' => 'Регистрация аккаунта',
  'nav_list' => $nav_list,
  'content' => $page_content
]);


print($layout_content);
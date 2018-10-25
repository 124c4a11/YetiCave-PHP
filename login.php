<?php


require_once 'init.php';
require_once 'data.php';
require_once 'userdata.php';
require_once 'functions.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $form = $_POST;
  $errors = [];

  if (isset($form['email'])) {
    if (!$form['email']) $errors['email'] = 'Введите e-mail';
  }
 
  if (isset($form['password'])) {
    if (!$form['password']) $errors['password'] = 'Введите пароль';
  }
  
  if (!isset($errors['email']) && !isset($errors['password'])) {
    $user = get_user_by_email($connect, $form['email']);

    if ($user) {
      if (password_verify($form['password'], $user['password'])) {
        $_SESSION['user'] = $user;
      } else {
        $errors['password'] = 'Неверный пароль';
      }
    } else {
      $errors['email'] = 'Этот пользователь не зарегистрирован';
    }
  }

  if (count($errors)) {
    $page_content = include_template('./templates/login.php', ['user' => $form, 'errors' => $errors, 'nav_list' => $nav_list]);
  } else {
    header('Location: /');
    exit();
  }
} else {
  if (array_key_exists('new_user', $_SESSION)) {
    $page_content = include_template('./templates/login.php', ['user' => $_SESSION['new_user'], 'nav_list' => $nav_list]);
  } else {
    $page_content = include_template('./templates/login.php', ['nav_list' => $nav_list]);
  }
}


$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => 'Вход',
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print($layout_content);
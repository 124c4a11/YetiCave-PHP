<?php

require_once('functions.php');
require_once('data.php');


$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';


$page_content = include_template('templates/index.php', ['lots' => $lots]);
$layout_content = include_template('templates/layout.php', [
    'pagetitle' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'content' => $page_content,
    'categories' => $categories
]);


print($layout_content);
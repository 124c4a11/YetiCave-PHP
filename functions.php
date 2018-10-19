<?php


require_once 'mysql_helper.php';


function format_price($price) {
  $price = number_format($price, 0, '', ' ');
  return $price . ' <b class="rub">р</b>';
}


function include_template($path, $data) {
  if (!file_exists($path)) return '';

  ob_start();
  extract($data);
  require_once($path);
  
  return ob_get_clean();
}


function get_remaining_time($end_date) {
  $now = time();
  $end_date = strtotime($end_date);
  $sec_to_end = $end_date - $now;
  $hours = floor($sec_to_end / 3600);
  $minutes = floor(($sec_to_end % 3600) / 60);

  return $hours . ':' . $minutes;
}


function get_user_by_email($connect, $email) {
  $sql = 'SELECT name, email, password, avatar FROM users WHERE email = ?';
  $stmt = db_get_prepare_stmt($connect, $sql, [$email]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  return mysqli_fetch_assoc($res);
}
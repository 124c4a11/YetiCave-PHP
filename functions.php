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
  $sql = 'SELECT id, name, email, password, avatar FROM users WHERE email = ?';
  $stmt = db_get_prepare_stmt($connect, $sql, [$email]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  return mysqli_fetch_assoc($res);
}


function get_category_id_by_name($connect, $name) {
  $sql = 'SELECT id FROM categories WHERE name = ?';
  $stmt = db_get_prepare_stmt($connect, $sql, [$name]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  return mysqli_fetch_row($res)[0];
}


function get_categories($connect) {
  $sql = 'SELECT * FROM categories ORDER BY id';
  $res = mysqli_query($connect, $sql);

  return mysqli_fetch_all($res, MYSQLI_ASSOC);
}


function get_lot_by_id($connect, $id) {
  $sql = 'SELECT l.*, u.name author, c.name category FROM lots l
          LEFT JOIN categories c ON c.id = l.category_id
          LEFT JOIN users u ON u.id = l.author_id
          WHERE l.id = ?';
  $stmt = db_get_prepare_stmt($connect, $sql, [$id]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  return mysqli_fetch_assoc($res);
}


function get_last_lots($connect, $limit, $offset) {
  $sql = 'SELECT l.id, l.name, end_date, image, start_price, c.name category FROM lots l
          JOIN categories c ON c.id = l.category_id
          WHERE end_date >= CURDATE()
          ORDER BY end_date DESC
          LIMIT ' . $limit . ' OFFSET ' . $offset;
  $res = mysqli_query($connect, $sql);

  return mysqli_fetch_all($res, MYSQLI_ASSOC);
}


function get_last_bets_for_lot($connect, $lot_id) {
  $sql = 'SELECT DATE_FORMAT(b.creation_date, "%d-%m-%Y %H:%i:%s") creation_date, b.price, b.user_id, u.name user_name FROM bids b
          LEFT JOIN users u ON u.id = b.user_id
          WHERE b.lot_id = ?
          ORDER BY creation_date DESC
          LIMIT 9';
  $stmt = db_get_prepare_stmt($connect, $sql, [$lot_id]);

  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);

  return mysqli_fetch_all($res, MYSQLI_ASSOC);
}
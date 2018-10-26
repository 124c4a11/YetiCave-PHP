<?php


require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';


session_start();


$nav_list = include_template('templates/blocks/nav-list.php', ['categories' => $categories]);
$lot = null;


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $popular_lots = [];
  $expire = strtotime('+1 day');
  $errors = [];

  $lot = get_lot_by_id($connect, $id);
  $last_bets = get_last_bets_for_lot($connect, $id);
  $max_bet = $last_bets[0]['price'];
  $step = $lot['step'];

  // get current price
  // and
  // get min cost
  if (isset($max_bet)) {
    $lot['current_price'] = $max_bet;
    $lot['min_cost'] = $max_bet + $step;
  } else {
    $lot['current_price'] = $lot['start_price'];
    $lot['min_cost'] = $lot['start_price'] + $step;
  }

  // cookie: popular_lots
  if (isset($_COOKIE['popular_lots'])) {
    $popular_lots = json_decode($_COOKIE['popular_lots'], true);

    if (!in_array($id, $popular_lots)) {
      $popular_lots[] = $id;
      $popular_lots = json_encode($popular_lots);
      setcookie('popular_lots', $popular_lots, $expire, '/');
    }
  } else {
    $popular_lots[] = $id;
    $popular_lots = json_encode($popular_lots);
    setcookie('popular_lots', $popular_lots, $expire, '/');
  }

  // POST: bet form processing
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bet = intval($_POST['cost']);
    $lot['bet'] = $bet;

    if (isset($bet)) {
      if ($bet < $lot['min_cost']) {
        $errors['bet'] = 'Ставка не может быть ниже минимальной';
      } else {
        if ($connect) {
          $user_id = $_SESSION['user']['id'];
          $lot_id = $lot['id'];
          $sql = 'INSERT INTO bids (price, user_id, lot_id) VALUES (?, ?, ?)';
          $stmt = db_get_prepare_stmt($connect, $sql, [$bet, $user_id, $lot_id]);
          $res = mysqli_stmt_execute($stmt);
      
          if ($res) {
            header('Location: lot.php?id=' . $lot_id);
            exit();
          }
        }
      }
    }
  }

  if (!$lot) {
    http_response_code(404);
  } else if (count($errors)) {
    $page_content = include_template('./templates/lot.php', ['lot' => $lot, 'last_bets' => $last_bets, 'errors' => $errors, 'nav_list' => $nav_list]);
  } else {
    $page_content = include_template('./templates/lot.php', ['lot' => $lot, 'last_bets' => $last_bets, 'nav_list' => $nav_list]);
  }
}


if (!$lot) http_response_code(404);


$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . ($lot['name'] ?? 'Лот не сеществует!'),
  'content' => $page_content,
  'nav_list' => $nav_list
]);


print($layout_content);
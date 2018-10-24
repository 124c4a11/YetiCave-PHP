<?php


require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';


session_start();


$lot = null;


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $popular_lots = [];
  $expire = strtotime('+1 day');

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
}


if (!$lot) http_response_code(404);


$page_content = include_template('./templates/lot.php', ['lot' => $lot, 'last_bets' => $last_bets]);
$layout_content = include_template('./templates/layout.php', [
  'pagetitle' => $config['sitename'] . ' - ' . ($lot['name'] ?? 'Лот не сеществует!'),
  'content' => $page_content,
  'categories' => $categories
]);


print($layout_content);
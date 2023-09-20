<?php
require_once './function.php';

// POSTをされたかどうか
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $pdo = dbConnect();
  // @todo validation check

  // account情報とPOSTの情報が一致するかどうか
  $account = checkLogin($pdo, $_POST['name'], $_POST['password']);

  if ($account) {
    $_SESSION['account'] = $account;
    // $account = findAccount($pdo, $_POST['name']);
    // var_dump($account);
    // // 一致した場合には、ログイン状態にする
    // $_SESSION['account'] = $account;
    // $_SESSION['login'] = $account['name'];
    // $_SESSION['isAdmin'] = ($account['isAdmin'] == 1);
  }
}
header('Location: /bbs.php');

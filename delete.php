<?php
require_once './function.php';
$pdo = dbConnect();

if (
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  $_POST['bbs_id']){

  // @todo bbs_idの存在確認
  
  // 削除処理
  deleteBbs($pdo);
}
header('Location: /bbs.php');

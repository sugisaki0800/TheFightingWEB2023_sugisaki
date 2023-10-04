<?php
require_once './function.php';
$pdo = dbConnect();

if (
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  $_POST['bbs_id']){
  deleteBbs($pdo);
}
header('Location: /bbs.php');

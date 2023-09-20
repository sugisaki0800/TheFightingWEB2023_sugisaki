<?php
require_once './function.php';

// var_dump($_POST);
if (
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  $_POST['bbs_id']){
  deleteBbs($_POST['bbs_id']);
}
header('Location: /bbs.php');

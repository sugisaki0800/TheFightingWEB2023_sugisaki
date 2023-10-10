<?php

define('COMMENT_FILE', './bbs/comment.txt');
session_start();

function checkLogin($pdo, $id, $password) {
    $account = findAccountByName($pdo, $id);
    return !empty($account) && password_verify($password, $account['password']) ? $account : false;
}

function findAccountByName($pdo, $id) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$id]);
    return $sth->fetch();
}

function checkDeplicateAccount($pdo, $name) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$name]);
    $result = $sth->fetchAll();
    return count($result) === 0;
}
function existsAccount($accounts, $id, $password) {
    // 配列データをloopして、一致する情報があるかを判定する
    foreach($accounts as $account) {
        if ($account['id'] === $id && password_verify($password, $account['pass'])) {
            return true;
        }
    }

    // 失敗ならfalse
    return false;
}

function validationPost($comment) {
    $result = [
        'comment' => true
    ];

    // comment -> 1024文字(2のn乗です) / 許容する文字に制限は設けない
    if (mb_strlen($comment) > 1024) {
        $result['comment'] = false;
    }

    return $result;
}

function saveAccount($pdo, $name, $password, $is_admin) {
    $sth = $pdo->prepare("INSERT INTO `accounts` (`name`, `password`, admin_flag) VALUE(?, ?, ?)");
    return $sth->execute([$name, password_hash($password, PASSWORD_BCRYPT), $is_admin ? 1 : 0]);
}

function requestPost($pdo) {
    $sth = $pdo->prepare("INSERT INTO `comments` (`account_id`, `comment`) VALUE(?, ?)");
    return $sth->execute([$_SESSION['account']['id'], $_POST['comment']]);
}

function getBbs($pdo) {
    $sth = $pdo->prepare("SELECT `comment`, `create_date`, `name`, comments.`id` FROM comments JOIN accounts ON comments.account_id = accounts.id");
    $sth->execute();
    return $sth->fetchAll();
}

function deleteBbs($pdo) {
    // var_dump($_POST['bbs_id']);
    $sth = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $sth->execute([$_POST['bbs_id']]);
}

function dbConnect() {
    try {
    $pdo = new PDO("mysql:host=mysql;dbname=bbs", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

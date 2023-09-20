<?php

define('COMMENT_FILE', './bbs/comment.txt');
// define('ACCOUNT_FILE', './bbs/account.csv');
define('BBS_ID_FILE', './bbs/bbs_id.txt');
session_start();

// function getAccountWithFile() {
//     $fh = openFile(ACCOUNT_FILE);
//     $accounts = getAccounts($fh);
//     closeFile($fh);
//     return $accounts;
// }

function checkLogin($pdo, $id, $password) {
    $account = findAccountByName($pdo, $id);
    var_dump($account);
    return !empty($account) && password_verify($password, $account['password']) ? $account : false;
    // $accounts = getAccountWithFile();
    // return existsAccount($accounts, $id, $password);
}

function findAccountByName($pdo, $id) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$id]);
    return $sth->fetch();
}
// function findAccount($id) {
//     $accounts = getAccountWithFile();
//     foreach($accounts as $account) {
//         if($account['id'] === $id) {
//             return $account;
//         }
//     }
//     return null;
// }

function checkDeplicateAccount($pdo, $name) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$name]);
    $result = $sth->fetchAll();
    return count($result) === 0;
    // $accounts = getAccountWithFile();
    // return existsAccountId($accounts, $id);
}

// function existsAccountId($accounts, $id) {
//     foreach($accounts as $account) {
//         if($account['id'] === $id) {
//             return false;
//         }
//     }
//     return true;
// }

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

function openFile($fileName, $mode = 'a+') {
    if (!file_exists($fileName)) {
        touch($fileName);
        chmod($fileName, 0777);
    }
    return fopen($fileName, $mode);
}

function closeFile($fh) {
    fclose($fh);
}

function validationPost($name, $comment) {
    $result = [
        'name' => true,
        'comment' => true
    ];

    // name -> アルファベット(大文字/小文字)と数字のみ / 32文字までに制限 / 3文字以上
    if (preg_match('/[A-Za-z0-9]{3,32}/', $name) !== 1) {
        $result['name'] = false;
    }

    // comment -> 1024文字(2のn乗です) / 許容する文字に制限は設けない
    if (mb_strlen($comment) > 1024) {
        $result['comment'] = false;
    }

    return $result;
}

function saveAccount($pdo, $name, $password, $is_admin) {
    $sth = $pdo->prepare("INSERT INTO `accounts` (`name`, `password`, admin_flag) VALUE(?, ?, ?)");
    return $sth->execute([$name, password_hash($password, PASSWORD_BCRYPT), $is_admin ? 1 : 0]);
    // $fh = openFile(ACCOUNT_FILE);
    // if(fputcsv($fh, [$id, password_hash($password, PASSWORD_BCRYPT), $is_admin ? 1 : 0]) === false) {
    //     // @todo エラーハンドリングをもっとまじめにするよ
    //     echo "やばいよ！";
    // }
}

function requestPost($fh) {
    $date = time();

    if(fputcsv($fh, [getBbsNextId(), $_POST['name'], $_POST['comment'], $date]) === false) {
        // @todo エラーハンドリングをもっとまじめにするよ
        echo "やばいよ！";
    } else {
        setLastId();
    }
}

function getAccounts($fh) {
    $accountArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $accountArray[] = [
            'id' => $buffer[0],
            'pass' => $buffer[1],
            'isAdmin' => $buffer[2]
        ];
    }
    return $accountArray;
}

function getBbs($fh) {
    $bbsArray = [];
    rewind($fh);
    while (($buffer = fgetcsv($fh, 4096)) !== false) {
        $bbsArray[] = [
            'id' => $buffer[0],
            'name' => $buffer[1],
            'comment' => $buffer[2],
            'date' => $buffer[3]
        ];
    }
    return $bbsArray;
}

function deleteBbs($id) {
    $fh = openFile(COMMENT_FILE);
    $bbs = getBbs($fh);
    closeFile($fh);

    $fh = openFile(COMMENT_FILE, 'w');
    foreach($bbs as $record) {
        if($record['id'] != $id) {
            if(fputcsv($fh, [$record['id'], $record['name'], $record['comment'], $record['date']]) === false) {
                echo "やばいよ！";
            }
        }
    }
    // fwrite($fh, $id);
    closeFile($fh);
}

function getBbsLastId() {
    $fh = openFile(BBS_ID_FILE);
    $id = fgets($fh);
    closeFile($fh);
    return (int)$id;
}
function getBbsNextId() {
    $id = getBbsLastId();
    return $id + 1;
}
function setLastId() {
    $id = getBbsNextId();
    $fh = openFile(BBS_ID_FILE, 'w');
    fwrite($fh, $id);
    closeFile($fh);
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

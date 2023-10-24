<?php
require_once './classes/Models/AccountsModel.php';

require_once './function.php';
// var_dump($_POST);
$result = [
//   'id' => true
  'name' => true
];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $account = new AccountsModel();
    $result = $account->findByCol($_POST['name'], 'name');
    if ($result['name'] === $_POST['name']) {
        $result['name'] = false;
    } else {
        $account->save();
    }
    // $pdo = dbConnect();
//   $result['name'] = checkDeplicateAccount($pdo, $_POST['name']);
//   if($result['name']) {
//     saveAccount($pdo, $_POST['name'], $_POST['password'], !empty($_POST['is_admin']));
//     header('Location: /bbs.php');
//   }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Formサンプル</title>
    </head>
    <style>
        .error-text {
            color: red;
        }
    </style>
    <body>
        <h1>BBS - account作成</h1>
        <div>
          <p>idとpasswordを入れてね</p>
        </div>
        <form action="/account.php" method="POST">
            <div>
                <label for="name">
                    ID:<input type="text" id="name" name="name" value="">
                </label>
                <?php if($result['name'] === false): ?>
                  <p class="error-text">重複したidが既に存在しています</p>
                <?php endif; ?>
            </div>
            <br>
            <div>
                <label for="password">
                    Password:<input type="password" id="password" name="password" value="">
                </label>
            </div>
            <br>
            <div>
                <label for="is_admin">
                    isAdmin:<input type="checkbox" id="is_admin" name="is_admin" />
                </label>
            </div>
            <br>
            <input type="submit" value="作成">
        </form>

        <hr />
    </body>
</html>

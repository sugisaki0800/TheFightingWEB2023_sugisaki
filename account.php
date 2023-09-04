<?php
require_once './function.php';
// var_dump($_POST);
$result = [
  'id' => true
];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $result['id'] = checkDeplicateAccount($_POST['id']);
  if($result['id']) {
    saveAccount($_POST['id'], $_POST['password']);
    header('Location: /bbs.php');
  }
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
                <label for="id">
                    ID:<input type="text" id="id" name="id" value="">
                </label>
                <?php if($result['id'] === false): ?>
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
            <input type="submit" value="作成">
        </form>

        <hr />
    </body>
</html>

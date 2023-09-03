<?php
require_once './function.php';
$result = [
    'name' => true,
    'comment' => true
];
$fh = openFile(COMMENT_FILE);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validation処理
    $result = validationPost($_POST['name'], $_POST['comment']);
    if ($result['name'] && $result['comment']) {
        // 保存処理
        requestPost($fh);
    }
}
$bbs = getBbs($fh);
closeFile($fh);

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
        .logout-wrap {
            text-align: right;
        }
    </style>
    <body>
        <h1>BBS</h1>

        <?php if ($_SESSION['login']): ?>
            <div class="logout-wrap"><a href="/logout.php">ログアウトする！</a></div>
            <form action="/bbs.php" method="POST">
                <!-- 名前 -->
                <div>
                    <label for="name">
                        名前：<input type="text" id="name" name="name" value="<?php echo $_SESSION['login']; ?>" />
                    </label>
                    <?php if($result['name'] === false): ?>
                        <p class="error-text">入力できるのは英数のみ3文字以上32文字以下です</p>
                    <?php endif; ?>
                </div>
                <br>
                <!-- コメント -->
                <div>
                    <label for="comment">
                        コメント：<textarea name="comment" id="comment" cols="0" rows="5"></textarea>
                    </label>
                    <?php if($result['comment'] === false): ?>
                        <p class="error-text">入力は1024文字までです。</p>
                    <?php endif; ?>
                </div>
                <!-- 画像は後で -->
                <br>
                <input type="submit" value="送信">
            </form>

        <?php else: ?>
            <form action="/login.php" method="POST">
                <div>
                    <label for="id">
                        ID:<input type="text" id="id" name="id" value="">
                    </label>
                </div>
                <br>
                <div>
                    <label for="password">
                        Password:<input type="password" id="password" name="password" value="">
                    </label>
                </div>
                <br>
                <input type="submit" value="Login">
            </form>
        <?php endif; ?>

        <hr />
        <h2>書き込み一覧だよー！</h2>
        <div>
            <?php
            foreach($bbs as $item):
            ?>
                <div>
                    <p>nama: <?php echo $item['name']; ?></p>
                    <p>comment: <?php echo str_replace(PHP_EOL, '<br>', $item['comment']); ?></p>
                    <p>date time: <?php echo date('Y/m/d H:i:s', $item['date']); ?></p>
                </div>
                <hr />
            <?php
            endforeach;
            ?>
        </div>
        <hr />

    </body>
</html>



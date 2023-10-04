<?php
require_once './function.php';
$result = [
    'name' => true,
    'comment' => true
];
$fh = openFile(COMMENT_FILE);
$pdo = dbConnect();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validation処理
    $result = validationPost($_POST['comment']);
    if ($result['comment']) {
        // 保存処理
        requestPost($pdo);
    }
}
$bbs = getBbs($pdo);
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

        <?php if ($_SESSION['account']): ?>
            <div class="logout-wrap"><a href="/logout.php">ログアウトする！</a></div>
            <form action="/bbs.php" method="POST">
                <!-- 名前 -->
                <div>
                    <label for="name">
                        名前：<input type="text" id="name" name="name" value="<?php echo $_SESSION['account']['name']; ?>" disabled />
                    </label>
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
                <br>
                <input type="submit" value="送信">
            </form>

        <?php else: ?>
            <form action="/login.php" method="POST">
                <div>
                    <label for="name">
                        ID:<input type="text" id="name" name="name" value="">
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
                    <p>name: <?php echo $item['name']; ?></p>
                    <p>comment: <?php echo str_replace(PHP_EOL, '<br>', $item['comment']); ?></p>
                    <p>date time: <?php echo $item['create_date']; ?></p>
                    <?php if($_SESSION['account']['admin_flag'] === 1): ?>
                        <form action="delete.php" method="POST">
                            <div>
                                <input type="submit" value="削除する" />
                                <input type="hidden" name="bbs_id" value="<?php echo $item['id']; ?>" />
                            </div>

                        </form>
                    <?php endif; ?>
                </div>
                <hr />
            <?php
            endforeach;
            ?>
        </div>
        <hr />

    </body>
</html>



<?php
require_once './function.php';
$fh = openFile();
requestPost($fh);
$bbs = getBbs($fh);
closeFile($fh);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Formサンプル</title>
    </head>
    <body>
        <h1>BBS</h1>
        <form action="/bbs.php" method="POST">
            <!-- 名前 -->
            <div>
                <label for="name">名前：
                    <input type="text" id="name" name="name">
                </label>
            </div>
            <br>
            <!-- コメント -->
            <div>
                <label for="comment">コメント：
                    <textarea name="comment" id="comment" cols="0" rows="5"></textarea>
                </label>
            </div>
            <!-- 画像は後で -->
            <br>
            <input type="submit" value="送信">
        </form>
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


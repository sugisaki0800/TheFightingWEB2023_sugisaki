<?php
echo 'こんにちは<br>やさしいせかい！！';
echo '<br>';

echo '名前：杉崎　瞬
<br>
年齢：34
<br>
住所：山梨県
<br>
職業：ローコードツール開発
<br>
趣味：音楽鑑賞
<br>
この会のモチベーション：愚直に勉強していきます！

';


// 自己紹介をするよ</p>
// 	<p>以下を参考に5分間で発表する内容を作ってください</p>
// 	<ol>
// 		<li>なまえ/ニックネーム</li>
// 		<li>職業</li>
// 		<li>趣味</li>
// 		<li>この会のモチベーション</li>





echo '<br>';
echo '<br>';


// for($i = 1;$i <= 100; $i++) {
//   if($i % 3 === 0) {
//       // 5でも割り切れるなら
//       if($i % 5 === 0) {
//           // その数が3でも5でも割り切れるなら数字の代わりに「FizzBuzz」を出力
//           echo "FizzBuzz";
//           echo PHP_EOL;
//       } else {
//           // 数字の代わりに「Fizz」を出力
//           echo "Fizz";
//       }
//   } else if ($i % 5 === 0) {
//   }
//   echo '<br>';
// }

echo '素数<br>';
echo 2 . PHP_EOL;
echo '<br>';
for($i = 3; $i <= 100; $i = $i + 2) {
    $result = true;
    // $i / $nの$nを作るLoop
    for ($j = 2; $j <= ceil(sqrt($j)); $j = $j + 2) {

        if ($i % $j === 0) {
            $result = false;
            break;
        }
    }
    if ($result) {
    echo $i . PHP_EOL;
    }
    echo '<br>';
}

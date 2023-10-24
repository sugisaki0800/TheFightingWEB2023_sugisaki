<pre>
<?php

require_once './classes/Models/AccountsModel.php';
require_once './classes/Models/CommentsModel.php';

$account = new AccountsModel();
$comment = new CommentsModel();

// $a = $account->findByCol(`admin`, `name`);
// $a = $account->findByCol(1);
// $a = $account->findByCol("admin", 'name');
// var_dump($a);

// $c = $comment->findByCol(2);
$c = $comment->findByCol(5);
var_dump($c);

// $d = $account->findAll();
// $d = $comment->findAll();
// var_dump($d);

?>
</pre>




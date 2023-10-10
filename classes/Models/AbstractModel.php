<?php

class AbstractModel
{
    private $pdo;
    protected $table_name;
    // var_dump($pdo);

    public function __construct()
    {
        $this->pdo = $this->dbConnect();
    }

    public function findByCol($val, $colName = 'id') {
        $sth = $this->getPdo()->prepare("SELECT * FROM " . $this->table_name . " WHERE `".$colName."` = ?");
        $sth->execute([$val]);
        return $sth->fetch();
    }

    public function findAll() {
        $sth = $this->getPdo()->prepare("SELECT * FROM ". $this->table_name);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function save() {
        if ($this->table_name === 'accounts') {
            // var_dump($a);
            $sth = $this->getPdo()->prepare("INSERT INTO `accounts` (`name`, `password`, admin_flag) VALUE(?, ?, ?)");
            return $sth->execute([$_POST['name'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['is_admin'] ? 1 : 0]);
        }

        // if ($this->getPdo()->table_name === 'comments') {
        //     $sth = $this->getPdo()->prepare("INSERT INTO `comments` (`account_id`, `comment`) VALUE(?, ?)")
        //     return $sth->execute([$_SESSION['account']['id'], $_POST['comment']]);
        // }
        // @todo
        // return [];
    }

    // public function update() {
    //     // @todo
    //     return [];
    // }

    // public function delete() {
    //     // @todo
    //     return [];
    // }

    protected function getPdo()
    {
        return $this->pdo;
    }

    private function dbConnect() {
        $pdo = new PDO("mysql:host=mysql;dbname=bbs", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
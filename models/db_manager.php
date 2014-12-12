<?php
// vim: fenc=utf8:
class DBManager {
    private $dbh;

    public function __construct(PDO $dbh) {
        $this->dbh = $dbh;
    }

    /**
     * logの追加
     * 既にある場合は新規挿入
     * 
     */
    public function add_log($time, $num) {
        if ($n = $this->get_log($time)) {
            $n += $num;
            $this->update_log($time, $n);
        } else {
            $this->insert_log($time, $num);
        }
    }

    public function replace_add($time, $num) {
        if ($this->get_log($time)) {
            $this->update_log($time, $num);
        } else {
            $this->insert_log($time, $num);
        }
    }

    public function update_log($time, $num) {
        $stmt = $this->dbh->prepare('UPDATE ' . DB_TN_TWEET_TIME_LOGS . ' SET timestamp = timestamp, num = :NUM  WHERE timestamp = :TIME');
        $stmt->bindValue(':TIME', $time);
        $stmt->bindValue(':NUM', $num);
        $stmt->execute();
    }

    public function insert_log($time, $num) {
        $stmt = $this->dbh->prepare('INSERT INTO ' . DB_TN_TWEET_TIME_LOGS . ' (timestamp, num) VALUES (:TIME, :NUM)');
        $stmt->bindValue(':TIME', $time);
        $stmt->bindValue(':NUM', $num);
        $stmt->execute();
    }

    public function get_log($time) {
        $stmt = $this->dbh->prepare('SELECT num FROM ' . DB_TN_TWEET_TIME_LOGS . ' WHERE timestamp = :TIME');
        $stmt->bindValue(':TIME', $time);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return @$row['num'];
    }

    public function delete_old_log($time) {
        $stmt = $this->dbh->prepare('DELETE FROM ' . DB_TN_TWEET_TIME_LOGS . ' WHERE timestamp < :TIME');
        $stmt->bindValue(':TIME', $time);
        $stmt->execute();
    }

    public function select_all() {
        $stmt = $this->dbh->query('SELECT * FROM ' . DB_TN_TWEET_TIME_LOGS);
        return $stmt;
    }
}

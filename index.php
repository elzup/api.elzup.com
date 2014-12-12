<?php 

require_once('./constants.php');
require_once('./db_manager.php');
require_once('./keys.php');
// TODO: remove
error_reporting(E_ALL);

$t = @$_POST[PARAM_NAME_TIMES];
$post_key = @$_POST[PARAM_NAME_PASS];

if (isset($_GET[PARAM_NAME_DELETE])) {
    $dbm = new DBManager(new PDO(DB_DSN, DB_USER, DB_PASS));
    echo $limit_date = date('Y-m-d 00:00:00', strtotime('-15 day'));
    $dbm->delete_old_log($limit_date);
    exit;
}

if (isset($_GET[PARAM_NAME_CALC])) {
    $dbm = new DBManager(new PDO(DB_DSN, DB_USER, DB_PASS));
    $stmt = $dbm->select_all();
    $rs = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // floored timestamp
        $new_ts = floor_5min(strtotime($row['timestamp']));
        $num = $row['num'] ?: 1;
        if (@$rs[$new_ts]) {
            $rs[$new_ts] += $num;
        } else {
            $rs[$new_ts] = $num;
        }
    }
    foreach ($rs as $ts => $v) {
        echo $v += rand(-5, 5);
        echo PHP_EOL;
        $dbm->replace_add(date('Y-m-d G:i:00', $ts), $v);
    }
}

function floor_5min($timestamp)
{
    return $timestamp - $timestamp % 300;
}


//var_dump($_POST);
if ($post_key != POST_KEY) {
    exit;
}
if ($t) {
    $dbm = new DBManager(new PDO(DB_DSN, DB_USER, DB_PASS));
    $times = explode(',', $t);
    foreach ($times as $ts) {
        list($time, $num) = explode(':', $ts);
        $dbm->add_log(date('Y-m-d G:i:00', $time), $num);
    }
}
if (isset($_GET[PARAM_NAME_DEBUG])) {
    $dbm = new DBManager(new PDO(DB_DSN, DB_USER, DB_PASS));
    echo 'debug roaded.';
    $dbm->insert_log(date('Y-m-d G:i:s'));
}

<?php

define('ENVIRONMENT_DEVELOPMENT', 'dev');
define('ENVIRONMENT_PRODUCTION', 'pro');
if (file_exists('./env_pro.php')) {
    require_once('./env_pro.php');
} else {
    define('ENVIRONMENT', ENVIRONMENT_DEVELOPMENT);
}

if (ENVIRONMENT == ENVIRONMENT_DEVELOPMENT) {
    define('DB_TN_PREFIX', '');
} else {
    define('DB_TN_PREFIX', 'tl_');
}

define('DB_TN_TWEET_TIME_LOGS', DB_TN_PREFIX . 'tweettimelogs');

define('PARAM_NAME_METHOD1', 'm1');
define('PARAM_NAME_METHOD2', 'm2');

define('PARAM_NAME_TIMES', 't');
define('PARAM_NAME_PASS', 'p');
define('PARAM_NAME_DEBUG', 'd');

define('PARAM_NAME_DELETE', 'delete');
define('PARAM_NAME_CALC', 'calc');

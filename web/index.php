<?php

use SushiBar\RestApi;

require(dirname(__FILE__) . '/../vendor/autoload.php');

session_name('application');
session_start();

$api = new RestApi(strtoupper($_SERVER['REQUEST_METHOD']));
$api->handleRequest();
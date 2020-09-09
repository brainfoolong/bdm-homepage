<?php
error_reporting(E_ALL);
set_time_limit(30);
ini_set("memory_limit", "128M");

define("BDM_ROOT_FOLDER", str_replace("\\", "/", __DIR__));
require __DIR__ . "/config.php";
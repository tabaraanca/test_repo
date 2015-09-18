<?php
require_once 'view_class.php';
$view = new view_class();

require_once 'db_class.php';
$db = new db_class();
$db->connect_db(DB_HOST,DB_USER,DB_PASS);
$db->select_db(DB_DATABASE);

require_once 'work_class.php';
require_once 'work_class.php';

?>
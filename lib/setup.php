<?php
if(!isset($_SESSION)) session_start();

require_once 'view_class.php';
require_once 'db_class.php';
require_once 'work_class.php';

$view = new view_class();

$db = new db_class();
$db->connect_db(DB_HOST,DB_USER,DB_PASS);
$db->select_db(DB_DATABASE);

$view->db = $db;

$work = new work_class();
$work->view = $view;
$work->session_namespace = SESSION_NAMESPACE;

?>
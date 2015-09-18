<?php 
require_once '../lib/config.php';
require_once '../lib/setup.php';

$view->loadView("home");

echo "<pre>"; var_dump($db->getCategories()); 
?>
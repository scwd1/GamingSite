<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/projects/Homepage/includes/linkdir.php");
require($globallinks['database']);
require($globallinks['header']);
require($globallinks['nav']);
require($profilelinks['main']);
require($globallinks['footer']);
?>
<?php 
require 'env.php';

if (!isset($_SESSION['username'])) {
    header('Location: '.$currentUrl.'/login');
    exit;
}

?>
<?php

//Error Reporting
ini_set('display_errors','On');
error_reporting(E_ALL);

//session user varible
$sessionUser = '';
if (isset($_SESSION['user'])) {
    $sessionUser = $_SESSION['user'];
}


//Routes

$tplDir     = "includes/templates/"; // Template Directory
$langDir    = "includes/languages/"; // languages Directory
$funcDir    = "includes/functions/"; // Functions Directory
$cssDir     = "layout/CSS/"; // Css Directory
$jsDir      = "layout/js/"; // Js Directory


// Includes
include 'admin/connection.php';
include $funcDir . 'functions.php';
include $langDir .'english.php';
include $tplDir . 'header.php';

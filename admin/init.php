<?php

//Routes

$tplDir     = "includes/templates/"; // Template Directory
$langDir    = "includes/languages/"; // languages Directory
$funcDir    = "includes/functions/"; // Functions Directory
$cssDir     = "layout/CSS/"; // Css Directory
$jsDir      = "layout/js/"; // Js Directory


// Includes
include $funcDir . 'functions.php';
include $langDir .'english.php';
include 'connection.php';
include $tplDir . 'header.php';

// Include Navbar On All Pages Expect The One With $noNavbar Variable
if (!isset($noNavbar)) { include $tplDir . 'navbar.php'; }
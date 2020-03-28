<?php
require_once 'database/dbAccess.php';
require_once 'database/dbAccess.php';
ob_start();
session_start();
// if session is not admin and also not user, this will redirect to login page
if( !isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    unset($_SESSION['user']);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

?>

<?php ob_end_flush(); ?>

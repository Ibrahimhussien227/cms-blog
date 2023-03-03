<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>

<?php
session_destroy();
header("Location: ../index.php");
 ?>

<?php
include_once "../db/base.php";

unset($_SESSION['user']);
header("location:../index.php");
?>
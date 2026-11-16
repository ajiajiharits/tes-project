<?php
session_start();
include "config.php";

if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
  header("Location: dashboard.php");
  exit();
}

if (!isset($_GET["id"])) {
  header("Location: admin.php");
  exit();
}

$id = $_GET["id"];

mysqli_query($conn, "DELETE FROM courses WHERE id='$id'");

header("Location: admin-dashboard.php");
exit();
?>
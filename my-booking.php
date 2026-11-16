<?php
session_start();
include 'config.php';

$id = $_SESSION['id'];

$query = mysqli_query($conn,
"SELECT * FROM booking
JOIN mobil ON book
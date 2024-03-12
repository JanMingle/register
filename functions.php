<?php
// includes/functions.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oasis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

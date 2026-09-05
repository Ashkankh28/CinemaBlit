<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != "admin") {
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (!isset($_POST['id']) || !isset($_POST['mtype'])) {
    header("Location: 404page.php");
    exit();
}

$id = intval($_POST['id']);
$mtype = intval($_POST['mtype']);

if ($mtype !== 0 && $mtype !== 1) {
    http_response_code(400);
    exit("Invalid mtype");
}

$stmt = mysqli_prepare($link, "UPDATE users SET mtype = ? WHERE id = ?");

mysqli_stmt_bind_param($stmt, "ii", $mtype, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    http_response_code(500);
    echo "error";
}

mysqli_stmt_close($stmt);
?>

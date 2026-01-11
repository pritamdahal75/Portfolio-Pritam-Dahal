<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "portfolio_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "error";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        echo "error";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
        exit;
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        echo "error";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "login_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];
            header("Location: todo.php");
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='index.php';</script>";
    }
}
?>

<?php
session_start();

require 'functions.php';

$error = false;

if (isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["passwords"])) {
            $_SESSION["login"] = true;
            $_SESSION["id_user"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            header("Location: index.php"); 
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-form">
    <h2>Login</h2>
    
    <form action="login.php" method="post"> 
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="submit">Masuk</button>
    </form>
    <h5>Tidak Punya Akun? <a href="register.php">Daftar</a></h5>
</div>
<?php if ($error): ?>
<script>
    alert("Username/Password Tidak Ditemukan");
</script>
<?php endif; ?>
</body>
</html>

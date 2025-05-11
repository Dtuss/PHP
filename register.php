<?php
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Akun Berhasil Terdaftar');
                window.location.href = 'login.php';
              </script>";
        exit;
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-form">
    <h2>Daftar</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="password2" placeholder="Confirm Password" required />
        <button type="submit" name="register">Daftar</button>
    </form>
</div>

</body>
</html>

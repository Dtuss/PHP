<?php

$conn = mysqli_connect("localhost", "root", "", "login_db");

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM users where username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
             alert('Username sudah terdaftar !')
             </script>";
        return false;
    }


    if($password !== $password2){
        echo "<script>
             alert('konfirmasi password tidak sesuai! ')
             </script>";
        return false;
    }

    $password = password_hash($password,PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES('', '$username','$password')");

    return mysqli_affected_rows($conn);

}
?>